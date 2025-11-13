<template>
<v-container fluid>
    <v-row dense>
        <v-col cols="4" lg="4" md="5" sm="6" class="text-left">
            <div class="my-n5">

            </div>
        </v-col>
        <v-col cols="4" lg="4" md="1" v-if="!$vuetify.breakpoint.smOnly"></v-col>
        <v-col cols="4" lg="4" md="6" sm="6" class="text-rigth">
            <v-simple-table style="border: 1px block" dense>
                <thead>
                    <tr style="background-color: #3c282f">
                        <th colspan="3" style="text-align: center; color: white; font-weight: bold">
                            TOTAL SAMPLE
                        </th>
                    </tr>
                    <tr style="background-color: #3c282f">
                        <th style="text-align: center; color: white">1</th>
                        <th style="text-align: center; color: white">2</th>
                        <th style="text-align: center; color: white">3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center">{{ firstFloor }}</td>
                        <td style="text-align: center">{{ secondFloor }}</td>
                        <td style="text-align: center">{{ thirdFloor }}</td>
                    </tr>
                </tbody>
            </v-simple-table>
            <template>
                <div>
                    <div class="table1-th">
                        SCANNED BY: JIMWELL C. PUNZALAN
                    </div>
                </div>
            </template>
        </v-col>
    </v-row>

    <v-row>
        <v-col>
            <v-simple-table :height="$vuetify.breakpoint.height- 290 + 'px'" fixed-header class="my-n3 mt-n5" style="border: 1px solid black">
                <thead>
                    <tr>
                        <th class="table-header">PANEL NO</th>
                        <th v-for="(counter,l) in picCols" :key="l" class="table-header">{{counter}}</th>
                        <!-- <th class="table-header">ACTIONS</th> -->
                    </tr>
                </thead>
                <tbody v-if="loadingTable">
                    <tr>
                        <td rowspan="4" colspan="9" class="text-center white">
                            <h3>Loading Images</h3>
                            <v-progress-circular loadingTable :size="90" :width="20" color="#3c282f" indeterminate></v-progress-circular>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <template>
                        <tr v-for="(item, i) in tableContent" :key="i" @mouseover="isHoveringRow(i)" @mouseleave="onMouseLeave()" @load="imageExists()">
                            <td class="table-headers">
                                <v-row>
                                    <v-col cols="3" class="text-left">
                                        <v-icon v-if="tdIndex == i" v-show="show" style="color: white !important" medium>
                                            mdi-play
                                        </v-icon>
                                    </v-col>
                                    <v-col class="text-left">
                                        {{ item.PanelNo }}
                                    </v-col>
                                </v-row>
                            </td>

                            <!-- NOTE: picture looping -->
                            <!-- max: ang pinaka latest na narating nung picture 
                    count: total na picture na meron
                    OpeningCam(item, counter, 'Capture')
              -->
                            <td v-for="(counter,k) in picCols" :key="k" @click="
                              item.max >= counter && item['no'+counter] != null
                              ? openPictureDialog(item, item['no'+counter])
                                : (item.max >= counter || item.count == counter-1) &&
                                  item['no'+counter] == null &&
                                  (item.finishFlag == null || item.finishFlag == 0) &&
                                  clkpanelact == ''
                                ? mUploadDialog(item, counter, 'Capture')
                                : ''

                            " class="viewborder" :style="
                              item.count+1 >= counter &&
                              (item.finishFlag == null || item.finishFlag == 0)
                              ? ''
                              : 'background-color:grey'
                            ">

                                <!-- NOTE: picture loading -->
                                <v-progress-circular size='30' style="padding: 0;margin: 0;" v-if="isLoadingCell == counter && item.PanelNo == currentPanelNo" color="black" indeterminate></v-progress-circular>
                                <!-- NOTE: camera logo -->

                                <v-icon v-else-if="item['no'+counter] == null" x-large>mdi-camera</v-icon>

                                <!-- NOTE: if theres a picture, show it -->
                                <img v-else class="imagefit" :src="'images/'+item['no'+counter]+'.jpg'+'?' + timechange + ''" contain />
                                
                            </td>

                        </tr>
                    </template>
                </tbody>
            </v-simple-table>
        </v-col>
    </v-row>
    <v-row>
        <v-col cols="6" class="text-left">

        </v-col>
        <v-col cols="6" class="text-right">

            <v-btn v-if="!isMobile" @click="(previewdialog = !previewdialog), getPdfUrl('preview')" :disabled="picContent.length == 0"  style="background-color: #3c282f; color: white; font-weight: bold">
                <v-icon class="ml-n3 mr-5">mdi-file-pdf-box</v-icon>PREVIEW
            </v-btn>
        </v-col>
    </v-row>

    <!--NOTE Dialog for ViewPicture -->
    <v-dialog v-model="pictureDialog" fixed class="dialog" content-class="elevation-0">
        <div align="center" fixed>
            <v-card align="center" :style="
            isMobile
              ? 'border-radius: 10px;border: 3px solid black;   width: 80vw;'
              : 'border-radius: 10px;border: 3px solid black; width: 70vw;'
          " class="dialog position: center">
                <v-row dense v-if="!isaxiosdel && !isaxiosupload">
                    <v-col cols="12" class="text-center">
                        <v-icon class="mt-2" fab size="60px" color="red" @click="(pictureDialog = false), (pictures = true)">mdi-close-circle
                        </v-icon>
                    </v-col>
                </v-row>
                <v-row dense>
                    <v-col cols="12" align="center">
                        <h1>{{ processItem.NameCode }}</h1>
                    </v-col>
                </v-row>
                <!-- {{ dialogItem }} -->

                <v-row dense>
                    <v-col cols="1" align="left" style="max-width: 80px; height: 40vh; padding-top: 130px">
                        <v-icon @click="Previous()" :disabled="dialogItem.PicNO == 1 || loading" style="color: black; cursor: pointer; max-width: 65px; text-align: center" size="100px">mdi-menu-left</v-icon>
                    </v-col>

                    <v-col v-if="loading">
                        <v-progress-circular loading :size="90" :width="20" color="#3c282f" indeterminate></v-progress-circular>
                    </v-col>
                    <v-col v-else align="center">
                        <div v-if="pictures">

                            <img :style="
                    isMobile ? 'height: 40vh; width: 40vw;' : 'height: 50vh; width: 50vw;'
                  " :src="
                    'images/'+
                    dialogItem.PanelNo +
                    '_' +
                    viewpageNO +
                    '.jpg?' +
                    timechange
                  " />
                        </div>
                        <div v-else>
                            <span style="height: 40vh; width: 40vw">
                                <h1>No Picture</h1>
                            </span>
                            <v-icon style="cursor: pointer" @click="!isMobile ? OpeningCam(dialogItem, viewpageNO, 'Capture') : ''" x-large>mdi-camera</v-icon>
                        </div>
                    </v-col>

                    <v-col cols="1" align="right" style="max-width: 80px; height: 40vh; padding-top: 130px">
                        <v-icon @click="Next()" :disabled="dialogItem.PicNO == 8 || viewpageNO == lastPic || loading" style="color: black; cursor: pointer; max-width: 65px; text-align: center" size="100">mdi-menu-right</v-icon>
                    </v-col>
                </v-row>

                <v-row align="center" class="justify-center">
                    <v-col cols="auto" sm="auto" md="auto" lg="2" class="justify-space-between">
                        <v-btn @click="OpeningCam(DialogPanelNo+'.jpg', 1, 'Retake')" style="font-weight: bold; background-color: #3c282f; color: white" :disabled="!pictures || isaxiosupload || isaxiosdel">
                            RETAKE
                        </v-btn>

                    </v-col>

                    <!-- Upload Button -->
                    <v-col cols="auto" sm="auto" md="auto" lg="2" class="justify-space-between">
                        <v-btn id="fileInputButton" onclick="document.getElementById('rfileInput').click()" style="font-weight: bold; background-color: #3c282f; color: white" :disabled="!pictures || isaxiosupload || isaxiosdel ">
                            <span v-if="!isaxiosupload">UPLOAD</span>
                            <v-progress-circular size='30' style="padding: 0;margin: 0;" v-else ></v-progress-circular>
                        </v-btn>

                        <input id="rfileInput" type="file" @change="uploadImage($event, 'retake')" style="display:none" accept="image/*" />
                    </v-col>
                    <v-col cols="auto" sm="auto" md="auto" lg="2" class="justify-space-between">
                        <v-btn style="font-weight: bold; background-color: #3c282f; color: white" @click="del(DialogPanelNo)" :disabled="!pictures || isaxiosupload || isaxiosdel">
                            <span v-if="!isaxiosdel">ERASE</span>
                            <v-progress-circular size='30' style="padding: 0;margin: 0;" v-else ></v-progress-circular>
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row align="center" class="justify-center">
                    <v-col sm="3" md="3" lg="3" align="center">
                        <h1>{{ dialogItem.PanelNo }}</h1>
                    </v-col>
                    <v-col sm="3" md="3" lg="3" align="center">
                        <h1>{{ dialogItem.PicNO }}</h1>
                    </v-col>
                </v-row>
            </v-card>
        </div>
    </v-dialog>

    <!-- NOTE Dialog for preview -->
    <v-dialog persistent width="1000" height="600" v-model="previewdialog" :content-class="isLoading ? 'elevation-0' : 'custom-scrollbar-hidden'">
        <div v-if="isLoading">
            <v-col cols="12" class="text-subtitle-1 text-center">
                <h3 class="white--text">Generating PDF <span class="dots"></span></h3>
            </v-col>
            <v-col v-if="isLoading" cols="12" class="text-subtitle-1 text-center">
                <v-progress-circular loading :size="90" :width="20" color="#FFFFFF" indeterminate></v-progress-circular>
            </v-col>
        </div>

        <v-card v-else id="create">
            <v-icon dark fab class="v-btn--floating" style="position: absolute; top: 25px; right: 40px; z-index: 1000" @click="previewdialog = !previewdialog" color="red">mdi-xamarin</v-icon>

            <iframe width="1000" height="600" ref="pdfview" :src="pdfPrint"></iframe>
            <v-btn color="green" dark fab class="v-btn--floating" style="position: absolute; bottom: 25px; right: 40px; z-index: 1000" @click="getPdfUrl('download')">
                <v-icon>mdi-download</v-icon>
            </v-btn>
        </v-card>
    </v-dialog>
    <!-- Jea -->
    <!-- NOTE: Mobile v-dialog -->
    <!-- Gives the user an option whether to capture an image or upload -->
    <v-dialog v-model="mobileDialog" width="400px" height="350px" persistent>

        <v-card align="center" class="pa-3">
            <v-row dense class="mb-2" v-if="!isaxiosupload">
                <v-col cols="12" class="text-center">
                    <v-icon class="mt-2" fab size="60px" color="red" @click="(mobileDialog = false), (pictures = true)">mdi-close-circle
                    </v-icon>
                </v-col>
            </v-row>

            <v-btn :disabled="isaxiosupload" v-if="(param && param.length > 0)" x-large color="primary" width="150px" height="60px" elevation="2" depressed @click="OpeningCam(param[0],param[1],param[2])">
                <!-- id="fileInputButton" onclick="document.getElementById('filecapture').click()"  -->
                <v-icon>mdi-camera</v-icon>
                Capture
            </v-btn>
            <!-- <input 
            id="filecapture" 
            type="file" 
            @change="uploadImage"
            style="display:none"
            accept="image/*"
            capture="true"

          /> -->
            <!-- v-if="isMobile" -->
            <v-btn :disabled="isaxiosupload" color="primary" width="150px" height="60px" elevation="2" depressed id="fileInputButton" onclick="document.getElementById('fileInput').click()" style="font-weight: bold; background-color: #3c282f; color: white" left>
                <div v-if="!isaxiosupload">
                    <v-icon>mdi-upload</v-icon>
                    Upload
                </div>
                

                <v-progress-circular size='30' style="padding: 0;margin: 0;" v-else ></v-progress-circular>
            </v-btn>

            <input id="fileInput" type="file" @change="uploadImage" style="display:none" accept="image/*" />

        </v-card>
    </v-dialog>
    <CameraVue :OpenCam="OpenCam" :imagePath="imagepath2" :currentPanelNo="currentPanelNo" :editHeader="processItem" :isretake="isretake" @closecam="
        OpenCam = 0;
        pdfPrint = '';
      " @loadsave="mLoadSave" @gettable="getPanelNo" />
</v-container>
</template>

<script>
import axios from "axios";
import CameraVue from "./Camera.vue";

export default {
    components: {
        CameraVue,
    },
    // ANCHOR: DATA
    data: () => ({
        // NOTE: Looping of picture column 
        picCols: [1, 2, 3, 4, 5, 6, 7, 8],
        clkpanelact: "",
        isaxiosdel:false,
        isaxiosupload:false,
        pdfPrint: "",
        isLoading: false,
        fab: false,
        hidden: false,
        tabs: null,
        pdfUrl: null,
        loadingPdfUrl: false,
        timechange:0,
        menuLeft: "mdi-menu-left",
        show: false,
        previewdialog: false,
        processItem: {},
        tableContent: [{
                PanelNo: "1SAMP1",
                count: 0,
                max: 0
            },
            {
                PanelNo: "1SAMP2",
                count: 0,
                max: 0
            },
            {
                PanelNo: "2SAMP1",
                count: 0,
                max: 0
            },
            {
                PanelNo: "2SAMP2",
                count: 0,
                max: 0
            },
            {
                PanelNo: "3SAMP1",
                count: 0,
                max: 0
            },
        ],
        picContent: [],
        tdIndex: null,
        firstFloor: 0,
        secondFloor: 0,
        thirdFloor: 0,
        pictureDialog: false,
        isMobile: false,
        OpenCam: 0,
        currentPanelNo: "",
        DialogPanelNo: "",
        dialogItem: "",
        page: 1,
        isretake: true,
        image_url: "",
        pictures: true,
        loading: false,
        loadingTable: false,
        param: [],
        mobileDialog: false,
        notificationSystem: {
            options: {
                toastpositions: {
                    position: "bottomRight",
                    timeout: 1200,
                    displayMode: 2,
                },
                toastpositionsOnly: {
                    position: "bottomRight",
                    displayMode: 2,
                },
            },
        },
        resultNotExist: [],
        resultNotExist: [],
        lastPic: 0,
        captured: null,
        imagepath: "",
        imagepath2: "",
        pdfexist: false,
        totalfinish: 0,
        isLoadingCell: 0,
        curPic: '',
        iscreate: {
            overlay: true,
            toastOnce: true,
            id: "question",
            zindex: 999,
            position: "center",
            buttons: [
                [
                    "<button><b>YES</b></button>",
                    (instance, toast) => {
                        instance.hide({
                                transitionOut: "fadeOut",
                            },
                            toast,
                            "button"
                        );
                        this.toswaprotate.kind = "swap";
                        this.ismenuSwapRotate = !this.ismenuSwapRotate;
                        this.searchTable = "";
                    },
                    true,
                ],
                [
                    "<button>NO</button>",
                    function (instance, toast) {
                        instance.hide({
                                transitionOut: "fadeOut",
                            },
                            toast,
                            "button"
                        );
                    },
                    false,
                ],
            ],
        },
    }),
    created() {
       
        this.getPanelNo();
    
    },

    computed: {

      
        viewpageNO() {
            return this.dialogItem.PicNO;
        },
    },

    methods: {
        mRefreshImage() {
            const currentDate = new Date();
            this.timechange = currentDate.toLocaleString();
        },
        mLoadSave(item) {
            this.currentPanelNo = item.slice(0, 6);
            this.isLoadingCell = item[7];

        },

        getPdfUrl(id) {
            let url;
            if (id == "preview") {
                if (this.pdfPrint == "") {
                    this.isLoading = true;
                  
                    url = `api/camera/${id}?data=${JSON.stringify(this.tableContent)}`;
                    axios
                        .get(url, {
                            responseType: "blob"
                        })
                        .then((res) => {
                            this.pdfPrint =
                                URL.createObjectURL(res.data) + "#toolbar=0&#navpanes=0&scrollbar=0";
                        })
                        .finally(() => (this.isLoading = false));
                }
            } else {
                const link = document.createElement("a");
                link.href = this.pdfPrint;
                link.setAttribute("download", 'Sample');
                document.body.appendChild(link);
                link.click();
                link.remove();
            }
        },

       

        Previous() {
            this.loading = true;

            for (let x = (Number(this.dialogItem.PicNO) - 1); x >= 1; x--) {
                if (this.dialogItem['no' + x]) {
                    this.pictures = true;
                    this.dialogItem.PicNO = x
                    break
                }

            }

            this.loading = false;

        },

        Next() {
            this.loading = true;

            for (let x = (Number(this.dialogItem.PicNO) + 1); x <= this.dialogItem.max; x++) {
                if (this.dialogItem['no' + x]) {
                    this.pictures = true;
                    this.dialogItem.PicNO = x
                    break
                }

            }

            this.loading = false;

        },
        del(item) {
            this.currentPanelNo = item.slice(0, 6)
            this.isLoadingCell = item[7]
            this.isaxiosdel = true
            axios
                .delete(
                    `api/camera/${item}`
                )
                .then((res) => {
                    if (res.data == 1) {
                        this.pdfPrint = "";
                        this.pictureDialog = false;
                        this.$swal
                        .fire({
                            title: "Image successfully deleted",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1000,
                        })
                        this.getPanelNo()
                    } else {
                         this.$swal.fire({
                            title: "Failed to delete image",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    }
                })
                .finally(() => {
                this.isaxiosdel = false
                this.getPanelNo()
                // location.reload()
                }
                
                
            );
        },
        // NOTE: upload method
        mUploadDialog(item, val, condition) {
            this.currentPanelNo = item.PanelNo;
            // console.log('item', item);

            if (condition == "Capture") {
                this.mobileDialog = true;
                this.isretake = false;
                this.param = [(item), val, condition];
                this.pictureDialog = false;

            } else if (condition == "Retake") {
                this.OpeningCam(item, val, condition);
            }

        },
        // NOTE Upload Image
        uploadImage(event, val) {
            this.isaxiosupload = true
            // console.log('here', this.param[1]);
            this.isLoading = true;

            let picNum = '';
            let titles = '';
            // for capture
            // gets the currentPanelno and pic no as the file name of the image to download
            if (val == undefined) {
                picNum = this.param[1];
                titles = this.currentPanelNo + "_" + picNum + ".jpg";
                this.isretake = false;

            }
            // for Retake/reupload of image
            else {
                titles = this.dialogItem.PanelNo + "_" + this.dialogItem.PicNO + ".jpg";
                this.isretake = true;

            }
            console.log(this.isretake, 'and', val);
            const file = event.target.files[0];

            let paramsObj = {};
            paramsObj.title = titles;
            paramsObj.path = this.imagepath2;
            paramsObj.isretake = this.isretake;
            paramsObj.count = 1;
            const formData = new FormData();
            formData.append("file0", file);
            formData.append("params", JSON.stringify(paramsObj));
            this.isLoadingCell = val !== undefined ? this.dialogItem.PicNO : this.param[1];
            axios({
                    method: "POST",
                    url: `api/camera`,
                    data: formData,
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {

                    if (res.data == 1) {
                        this.$swal
                            .fire({
                                title: "Image successfully saved",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1000,
                            })
                            .then(() => {
                                // Only enables the loading for the selected Panel and Picno
                                
                                // console.log('panel', this.currentPanelNo)
                               
                                this.isLoading = false;
                            })
                            // .finally(() => {
                                // if (this.isretake) location.reload();
                                //    this.isaxiosupload = false
                                //     this.getPanelNo();
                                // else 
                             
                            // });
                    } else {
                        this.$swal.fire({
                            title: "Failed to save image",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    }

                    // this.stopCameraStream();
                })
                .catch(({
                    response
                }) => {
                    this.$swal.fire({
                        title: "Failed to save image",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                })
                .finally(() => {
                    this.mobileDialog = false;
                    this.pictureDialog = false;
                    this.isaxiosupload = false
                    this.getPanelNo();
                });
        },
        stopCameraStream() {
            this.closeCam();
            let tracks = this.$refs.camera.srcObject.getTracks();
            tracks.forEach((track) => {
                track.stop();
            });
        },
        closeCam() {
            this.$emit("closecam");
        },
        openPictureDialog(item, val) {
            let str = val[7];
            this.dialogItem = {
                PicNO: str,
                ...item
            };
            // console.log(this.dialogItem, 'fafwfawfa')
            this.pictures = true;
            this.pictureDialog = true;
            this.DialogPanelNo = val;
            this.lastPic = item.max;
        },
        // NOTE: Opening Cam

        OpeningCam(item, val, condition) {
            // console.log(item, val, condition, 'test');
            if (val) {
                this.processItem.curPicNo = val;
                // console.log('this', this.processItem.curPicNo);
                if (condition == "Capture") {
                    //OpenCam is previously a boolean
                    this.OpenCam = item.count + 1;

                    this.currentPanelNo = item.PanelNo + "_" + val + ".jpg";
                    this.curPic = val;
                    this.isretake = false;
                } else if (condition == "Retake") {
                    this.isretake = true;
                    this.currentPanelNo = item;
                    this.OpenCam = 1;
                }
            } else {
                this.OpenCam = item.count;
                this.currentPanelNo = item;
            }
        },
        // NOTE: Save Picture

        savePicture(item, val, condition) {
            // console.log('this', item);
            if (condition == "Retake") {
                this.isretake = true;
            } else {
                this.isretake = false;

            }
            let paramsObj = {};
            paramsObj.title = item;
            paramsObj.path = this.imagepath2;
            paramsObj.isretake = this.isretake;
            paramsObj.count = 1;
            const formData = new FormData();
            formData.append("file0", this.captured);
            formData.append("params", JSON.stringify(paramsObj));

            const url = window.URL.createObjectURL(new Blob([this.captured]))
            const link = document.createElement("a");
            link.href = url
            link.setAttribute("download", 'WEEK' + this.processItem.RequestWeek + '_' + this.processItem.NameCode + '_' + item)
            document.body.appendChild(link)
            link.click();
            link.remove();

            axios
                .post(`api/camera`, formData)
                .then((res) => {
                    this.currentPanelNo = val.PanelNo;
                    this.isLoadingCell = item[7];
                    if (res.data == 1) {

                        if (this.isretake) {
                            this.$swal
                                .fire({
                                    title: "Image successfully saved",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1000,
                                })
                                .then(() => {

                                    this.pdfPrint = "";

                                    // reload the page if the process is retake
                                    // Else :call the getPanelNo so that the page wont reload and the user stays to 
                                    // the current panel no that they are processing
                                    location.reload();

                                });
                        } else {
                            this.$swal
                                .fire({
                                    title: "Image successfully saved",
                                    icon: "success",
                                    showDenyButton: true,
                                    confirmButtonText: "Done",
                                    denyButtonText: `Next`
                                })
                                .then((result) => {
                                    if (result.isConfirmed) {
                                        this.pdfPrint = "";

                                        this.getPanelNo();
                                    } else {
                                        const fileInput = this.$refs.file5;
                                        // console.log(fileInput)
                                        if (fileInput) {
                                            fileInput.click();
                                        }
                                    }

                                });
                        }

                    } else {
                        this.$swal.fire({
                            title: "Failed to save image",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1000,
                        });
                    }
                })
                .catch(({
                    response
                }) => {
                    this.$swal.fire({
                        title: "Failed to save image",
                        icon: "error",
                        showConfirmButton: false,
                        timer: 1000,
                    });
                })
            // .finally(()=>{
            // this.isLoadingCell = 0;
            //   const url = window.URL.createObjectURL(new Blob([this.captured]))
            //   const link = document.createElement("a");
            //   link.href = url
            //   link.setAttribute("download", 'WEEK'+this.processItem.RequestWeek+'_'+this.processItem.NameCode+'_'+titles)
            //   document.body.appendChild(link)
            //   link.click();
            //   link.remove();

            // });
        },

        showf(i) {
            if (i == this.tdIndex) {
                this.show = true;
            } else {
                this.show = false;
            }
        },
        isHoveringRow(index) {
            this.tdIndex = index;
            this.showf(index);
        },
        onMouseLeave() {
            this.show = false;
        },
        floorComputation() {
          this.firstFloor = 0
          this.secondFloor = 0
          this.thirdFloor = 0
            for(let x= 0; x<this.tableContent.length;x++){
              if(this.tableContent[x].PanelNo.includes('1S'))
                this.firstFloor = this.firstFloor+this.tableContent[x].count
              else if(this.tableContent[x].PanelNo.includes('2S'))
                this.secondFloor = this.secondFloor+this.tableContent[x].count
              else
                this.thirdFloor = this.thirdFloor+this.tableContent[x].count
            }
       
        },
        // ANCHOR: getPanelNo
        getPanelNo() {
            this.mobileDialog = false
            // this.isLoading=true;
            this.mRefreshImage()
            axios
                .get(
                    `api/camera`
                )
                .then((res) => {
                    // disables the laoding after the image is done uploading & loading
                    this.pictureDialog = false;
                   
                    this.isLoadingCell = 0;
                    this.pictures = true;
                    // reload the images in the tbale
                    this.picContent = res.data;
                    
                    this.isLoading = false;

                })
                .finally(() => {
                    setTimeout(() => {
                        this.clkpanelact = "";
                    }, 1000);

                    this.tableContent = [{
                            PanelNo: "1SAMP1",
                            count: 0,
                            max: 0
                        },
                        {
                            PanelNo: "1SAMP2",
                            count: 0,
                            max: 0
                        },
                        {
                            PanelNo: "2SAMP1",
                            count: 0,
                            max: 0
                        },
                        {
                            PanelNo: "2SAMP2",
                            count: 0,
                            max: 0
                        },
                        {
                            PanelNo: "3SAMP1",
                            count: 0,
                            max: 0
                        },
                    ]

                    for (let x = 0; x < this.tableContent.length; x++) {
                        this.tableContent[x].count = 0
                        for (let y = 0; y < this.picContent.length; y++) {
                            if (this.picContent[y].includes(this.tableContent[x].PanelNo)) {
                                this.tableContent[x].count++
                                this.tableContent[x]['no' + this.picContent[y][7]] = this.picContent[y]
                                if (this.tableContent[x].max < Number(this.picContent[y][7])) {
                                    this.tableContent[x].max = Number(this.picContent[y][7])
                                }

                            }

                        }

                    }
                    this.floorComputation();
                    this.loadingTable = false;

                });
        },
    },
};
</script>

<style>
#toolbar {
    display: none !important;
}

#navpanes {
    display: none !important;
}

#sidebar {
    display: none !important;
}

#zoomIn {
    display: none !important;
}

#zoomOut {
    display: none !important;
}

.dialog {
    margin: 20px;
    padding: -16px;
}

.imagefit {
    height: 100%;
    width: 100%;
    display: block;
}

.table1-th {
    font-size: large;
    font-weight: bold;
    font-family: Arial, Helvetica, sans-serif;
}

.table-header {
    z-index: 5 !important;
    height: 50px !important;
    width: 200px !important;
    text-align: center !important;
    color: white !important;
    background-color: #3c282f !important;
}

.table-headers {
    position: sticky;
    left: 0;
    z-index: 2;
    height: 50px !important;
    width: 200px !important;
    text-align: center !important;
    color: white !important;
    background-color: #3c282f !important;
}

.viewborder {
    cursor: pointer;
    height: 100px !important;
    width: 200px;
    text-align: center;
    border: 1px solid black !important;
    padding: 0 !important;
}

.video {
    object-fit: fill;
}

.video-container {
    position: relative;
    width: fit-content;
}

.play-button {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
    background: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
}

.swal-button--white-text {
    color: white !important;
}

.camera-button .v-file-input {
    display: none;
}

#create .v-btn--floating {
    position: relative;
}

.dots::after {
    content: "";
    display: inline-block;
    width: 1em;
    text-align: left;
    animation: dots 1.5s steps(4, end) infinite;
}

html::-webkit-scrollbar {
    display: none;
}

@keyframes dots {

    0%,
    20% {
        content: "";
    }

    40% {
        content: ".";
    }

    60% {
        content: "..";
    }

    80%,
    100% {
        content: "...";
    }
}

.custom-scrollbar-hidden {
    overflow: hidden !important;
    scrollbar-width: none !important;
    -ms-overflow-style: none !important;

    & ::-webkit-scrollbar {
        display: none;
    }

    & * {
        overflow: hidden !important;
    }

    #create iframe {
        overflow: hidden !important;
        scrollbar-width: none !important;
        -ms-overflow-style: none !important;
    }

    #create iframe::-webkit-scrollbar {
        display: none;
    }

}
</style>
