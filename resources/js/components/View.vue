<template>
<v-container fluid>
    <v-row dense>
        <v-col cols="3" class="text-left">
            <div>

                <v-simple-table dense>
                    <thead>
                        <tr>
                            <th class="table1-th">CDNO</th>
                            <td style="font-weight: bold;  ">{{ processItem.CDNO }}</td>
                        </tr>
                        <tr>
                            <th class="table1-th">HCODE</th>
                            <td style="font-weight: bold;">{{processItem.HCODE }}</td>
                        </tr>
                        <tr>
                            <th class="table1-th">REQUEST</th>
                            <td style="font-weight: bold;">{{processItem.REQUEST}}-{{trimYear }}</td>
                        </tr>
                        <tr>
                            <th class="table1-th">DESTINATION</th>
                            <td style="font-weight: bold;">{{processItem.DESTINATION}}</td>
                        </tr>
                    </thead>
                </v-simple-table>

            </div>
        </v-col>
        <v-col cols="5"></v-col>
        <v-col cols="4" class="text-rigth">
            <v-simple-table style="border: 1px block;" dense>
                <thead>
                    <tr style="background-color:  #3C282F;">
                        <th colspan="3" style="text-align:center; color: white; font-weight: bold;">TOTAL PANEL</th>
                    </tr>
                    <tr style="background-color:  #3C282F; ">
                        <th style="text-align:center; color: white;">1F</th>
                        <th style="text-align:center; color: white;">2F</th>
                        <th style="text-align:center; color: white;">3F</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center">{{ mCountTotal('1F') }}</td>
                        <td style="text-align:center">{{ mCountTotal('2F') }}</td>
                        <td style="text-align:center">{{ mCountTotal('3F') }}</td>
                    </tr>
                </tbody>
            </v-simple-table>
            <template>
                <div>
                    <div class="table1-th">
                        SCANNED BY: Jimwell
                    </div>
                </div>
            </template>
        </v-col>

    </v-row>

    <v-row>
        <v-col>
            <v-simple-table :height="$vuetify.breakpoint.height-360+'px'" fixed-header>
                <thead>
                    <tr>
                        <th class="table-header">PANEL NO</th>
                        <th class="table-header">1</th>
                        <th class="table-header">2</th>
                        <th class="table-header">3</th>
                        <th class="table-header">4</th>
                        <th class="table-header">5</th>
                        <th class="table-header">6</th>
                        <th class="table-header">7</th>
                        <th class="table-header">8</th>
                    </tr>

                </thead>
                <tbody>
                    <template>
                        <tr v-for="(item, i) in tableContent" :key="i" @mouseover="isHoveringRow(i)" @mouseleave="onMouseLeave()">
                            <td class="table-headers">
                                <v-row>
                                    <v-col cols="3" class="text-left">
                                        <v-icon v-if="tdIndex == i" v-show="show" style="color: white !important;" medium>
                                            mdi-play
                                        </v-icon>
                                    </v-col>
                                    <v-col class="text-left">
                                        {{ item.PanelNo }}
                                    </v-col>
                                </v-row>

                            </td>

                            <td @click="openPictureDialog(item, item.no1)" class="viewborder">
                                <label class="camera-button" v-if="mPicExist(item.PanelNo+'_1')">
                                    <v-icon x-large>mdi-camera</v-icon>
                                    <v-file-input v-if="isMobile" v-model="captured" @change="savePicture(item.PanelNo )" accept="image/*;capture=camera"></v-file-input>
                                </label>

                                <img v-else class="imagefit" :src="'image/'+item.PanelNo+'_1.jpg'" contain />
                            </td>
                            <td @click="!isMobile && mPicCount(item.PanelNo) >= 1 ? OpeningCam(item.PanelNo):''" class="viewborder" :style="mPicCount(item.PanelNo) >= 1 ? '':'background-color:grey'">
                                <label class="camera-button" v-if="mPicExist(item.PanelNo+'_2')">
                                    <v-icon x-large>mdi-camera</v-icon>
                                    <v-file-input v-if="isMobile" v-model="captured" @change="savePicture(item.PanelNo)" accept="image/*;capture=camera"></v-file-input>
                                </label>

                                <img v-else class="imagefit" height="100" width="150" :src="'image/'+item.PanelNo+'_2.jpg'" />
                            </td>
                            <td @click="!isMobile && mPicCount(item.PanelNo) >= 2 ? OpeningCam(item.PanelNo):''" class="viewborder" :style="mPicCount(item.PanelNo) >= 2 ? '':'background-color:grey'">
                                <label class="camera-button" v-if="mPicExist(item.PanelNo+'_3')">
                                    <v-icon x-large>mdi-camera</v-icon>
                                    <v-file-input v-if="isMobile" v-model="captured" @change="savePicture(item.PanelNo)" accept="image/*;capture=camera"></v-file-input>
                                </label>

                                <img v-else class="imagefit" height="100" width="150" :src="'image/'+item.PanelNo+'_3.jpg'" />
                            </td>
                            <td @click="!isMobile && mPicCount(item.PanelNo) >= 3 ? OpeningCam(item.PanelNo):''" class="viewborder" :style="mPicCount(item.PanelNo) >= 3 ? '':'background-color:grey'">
                                <label class="camera-button" v-if="mPicExist(item.PanelNo+'_4')">
                                    <v-icon x-large>mdi-camera</v-icon>
                                    <v-file-input v-if="isMobile" v-model="captured" @change="savePicture(item.PanelNo)" accept="image/*;capture=camera"></v-file-input>
                                </label>

                                <img v-else class="imagefit" height="100" width="150" :src="'image/'+item.PanelNo+'_4.jpg'" />
                            </td>
                            <td @click="!isMobile && mPicCount(item.PanelNo) >= 4 ? OpeningCam(item.PanelNo):''" class="viewborder" :style="mPicCount(item.PanelNo) >= 4 ? '':'background-color:grey'">
                                <label class="camera-button" v-if="mPicExist(item.PanelNo+'_5')">
                                    <v-icon x-large>mdi-camera</v-icon>
                                    <v-file-input v-if="isMobile" v-model="captured" @change="savePicture(item.PanelNo)" accept="image/*;capture=camera"></v-file-input>
                                </label>

                                <img v-else class="imagefit" height="100" width="150" :src="'image/'+item.PanelNo+'_5.jpg'" />
                            </td>
                            <td @click="!isMobile && mPicCount(item.PanelNo) >= 5 ? OpeningCam(item.PanelNo):''" class="viewborder" :style="mPicCount(item.PanelNo) >= 5 ? '':'background-color:grey'">
                                <label class="camera-button" v-if="mPicExist(item.PanelNo+'_6')">
                                    <v-icon x-large>mdi-camera</v-icon>
                                    <v-file-input v-if="isMobile" v-model="captured" @change="savePicture(item.PanelNo)" accept="image/*;capture=camera"></v-file-input>
                                </label>

                                <img v-else class="imagefit" height="100" width="150" :src="'image/'+item.PanelNo+'_6.jpg'" />
                            </td>
                            <td @click="!isMobile && mPicCount(item.PanelNo) >= 6 ? OpeningCam(item.PanelNo):''" class="viewborder" :style="mPicCount(item.PanelNo) >= 6 ? '':'background-color:grey'">
                                <label class="camera-button" v-if="mPicExist(item.PanelNo+'_7')">
                                    <v-icon x-large>mdi-camera</v-icon>
                                    <v-file-input v-if="isMobile" v-model="captured" @change="savePicture(item.PanelNo)" accept="image/*;capture=camera"></v-file-input>
                                </label>

                                <img v-else class="imagefit" height="100" width="150" :src="'image/'+item.PanelNo+'_7.jpg'" />
                            </td>
                            <td @click="!isMobile && mPicCount(item.PanelNo) >= 7 ? OpeningCam(item.PanelNo):''" class="viewborder" :style="mPicCount(item.PanelNo) >= 7 ? '':'background-color:grey'">
                                <label class="camera-button" v-if="mPicExist(item.PanelNo+'_8')">
                                    <v-icon x-large>mdi-camera</v-icon>
                                    <v-file-input v-if="isMobile" v-model="captured" @change="savePicture(item.PanelNo)" accept="image/*;capture=camera"></v-file-input>
                                </label>

                                <img v-else class="imagefit" height="100" width="150" :src="'image/'+item.PanelNo+'_8.jpg'" />
                            </td>

                        </tr>
                    </template>

                </tbody>
            </v-simple-table>
        </v-col>
    </v-row>
    <v-row>
        <v-col cols="6" class="text-left">
            <v-btn style="background-color:  #3C282F; color: white;" @click=" $router.push('/schedule') ">
                <v-icon class="ml-n3 mr-5" x-large>mdi-menu-left</v-icon> BACK
            </v-btn>
        </v-col>
        <v-col cols="6" class="text-right">
            <v-btn @click="createPDF()" style="background-color:  #3C282F;  color: white;">
                <v-icon class="ml-n3 mr-5">mdi-file-pdf-box</v-icon>CREATE PDF
            </v-btn>
        </v-col>
    </v-row>

    <v-dialog  v-model="pictureDialog" fixed class="dialog">
        <div   align="center" fixed>
        <v-card  align="center" style="border-radius: 10px;border: 3px solid black;  position: center; height: 70vh;width: 53vw;" class="dialog" >
    
            <v-row>
                <v-col cols="12" class="text-center" >
                    <v-icon fab x-large color="red" @click="pictureDialog= false">mdi-close-circle
                    </v-icon>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" align="center"><h1>DH234</h1></v-col>
            </v-row>

           
            <v-row dense>
                <v-col style=" margin:0 !important;padding-top:40px;  max-width: 80px;">
                    <div>
                     <v-icon color="black"  style=" max-width: 65px; margin: 0px;padding-top:40px  " size="150px" >mdi-menu-left</v-icon>
                    </div>
               </v-col>
               <v-col align="center">
                     <div  >
                     <img  style="height: 40vh;width: 40vw;"  :src="'storage/image/'+currentPanelNo"  />
                    </div>
               </v-col>
               <v-col style="margin:0 !important;padding-top:40px; max-width: 80px;" >
                    <div>
                     <v-icon  color="black" style="max-width: 65px;margin: 0px;padding-top:40px ;  " size="150px"  >mdi-menu-right</v-icon>
                    </div>
                </v-col>
            </v-row>

            <v-row align="center" justify="center">
                <v-col  align="right">
                    <v-btn color="green" density="comfortable" left rounded @click="OpeningCam(currentPanelNo)">Replace</v-btn>
                </v-col>
                <v-col  align="center">
                    <h1>1F-001</h1>
                </v-col>
                <v-col  align="center">
                    <h1>1</h1>
                </v-col>
                <v-col  align="left">
                    <v-btn color="red" density="comfortable" right rounded @click="deleteImage()">Erase</v-btn>
                </v-col>                  
                </v-row>
         
            </v-card>  
         </div>
    </v-dialog>
     <v-footer color="titlecolor" dark fixed>
        <div>
            <span>This function represents the camera capture function of the (Nail Pitch System) which can take pictures and store it locally or through the server.</span>
            <br>
            <span class="red--text">Note: This program has been modified, some function may not work!</span>
        </div>
    </v-footer>
    <CameraVue :OpenCam="OpenCam" :currentPanelNo="currentPanelNo" :editHeader="processItem" @closecam="OpenCam = false" />
</v-container>
</template>

<script>
import axios from 'axios';
import CameraVue from './Camera.vue'
import { pickBy } from 'lodash';

export default {
    components: {
        CameraVue
    },
    data: () => ({
    menuLeft: 'mdi-menu-left',
        show: false,
        processItem: {CDNO:'TEST204-CDNO', HCODE:'HCTEST', REQUEST: '41-24', DESTINATION:'N/A'},
        trimYear: '',
        tableContent: [{PanelNo:'1F-001'},{PanelNo:'1F-002'},{PanelNo:'1F-003'},{PanelNo:'2F-001'},],
        overdata: '',
        currentHoveredRow: null,
        tdIndex: null,
        firstFloor: 0,
        secondFloor: 0,
        thirdFloor: 0,
        pictureDialog:false,
        isMobile: false,
        OpenCam: false,
        currentPanelNo: '1F-001',
        picfiles: [],
        captured:null


    }),
    created() {
        this.mGet()
        this.trimYear = 2024
        // this.getPanelNo()
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            this.isMobile = true
        }
    },
    computed: {

    },
    methods: {
        mCountTotal(val){
            return this.picfiles.filter(rec => rec.includes(val)).length
        },
        mPicCount(val){
            return this.picfiles.filter(rec => rec.includes(val)).length
        },
        mPicExist(val){
            if(this.picfiles.filter(rec => rec == val).length){
                return false
            }
            
            else
                return true
            
        },
        mGet(){
            axios.get(`api/camera`)
            .then(res => {
                this.picfiles = res.data
            })
        },
        openPictureDialog( item, val){
            console.log(item, 'item');

            if(item.no1 == null){
                !this.isMobile ? this.OpeningCam(item.PanelNo) : '';
            }else{

            this.pictureDialog= true;
            this.currentPanelNo = val
            console.log(this.currentPanelNo);
            }
        },

        OpeningCam(item) {
          
            this.OpenCam = true
            this.currentPanelNo = item
        },
        savePicture(item) {
            let paramsObj = {};
            paramsObj.title = item
            paramsObj.isretake = 0
            paramsObj.path = "image"
            const formData = new FormData();
            formData.append("file", this.captured);
            formData.append("params", JSON.stringify(paramsObj));

            axios.post(`api/camera`, formData)
                .then((res) => {})
                .catch(({
                    response
                }) => {
                    this.$router.push("/error/" + response.status);
                });
            location.reload()

        },
        createPDF() {
            return alert('This button is not yet functional')
        },
        showf(i) {
            if (i == this.tdIndex) {
                this.show = true;
            } else {
                this.show = false
            }
        },
        isHoveringRow(index) {
            this.tdIndex = index
            this.showf(index)
        },
        onMouseLeave() {
            this.show = false
        },

        floorConputation() {
            let firstCount = this.tableContent.filter(res => {
                return res.PanelNo.toUpperCase().includes('1F')
            });
            let secondCount = this.tableContent.filter(res => {
                return res.PanelNo.toUpperCase().includes('2F')
            });
            let thirdCount = this.tableContent.filter(res => {
                return res.PanelNo.toUpperCase().includes('3F')
            })

            this.firstFloor = firstCount.length
            this.secondFloor = secondCount.length
            this.thirdFloor = thirdCount.length
            // console.log(firstCount, 'count');
        },
        getPanelNo() {
            let Request = this.processItem.RequestWeek + '-' + this.processItem.RequestYear
            axios.get(`api/view?request=${Request}&&cdno=${this.processItem.ConstructionCode}&&hcode=${this.processItem.NameCode}`)
                .then((res) => {
                    this.tableContent = res.data
                    // this.$store.commit('setEditView', res.data)
                    this.floorConputation()
                    console.log(this.tableContent);
                })

        }
    }
}
</script>

<style>
.dialog{
    transition-timing-function: ease-in; 
    transition: width 15s;
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
    background-color: #3C282F !important;
}

.table-headers {
    position: sticky;
    left: 0;
    z-index: 2;
    height: 50px !important;
    width: 200px !important;
    text-align: center !important;
    color: white !important;
    background-color: #3C282F !important;
}

.viewborder {
    height: 100px !important;
    width: 200px;
    text-align: center;
    border: 1px solid black !important;
    padding: 0 !important;
}
</style>
