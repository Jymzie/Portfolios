<template>
<v-container fluid>
   
    <v-dialog v-model="OpenCam" fullscreen>
        <v-card flat color="black">
            <v-card-text>

                <div class="text-center video-container">

                    <video v-show="!isPhotoTaken" class="video" ref="camera" autoplay :width="window.width - 45 + 'px'" :height="window.height - 120 + 'px'" />
                    <canvas v-show="isPhotoTaken" class="video" id="photoTaken" ref="canvas" :width="window.width - 45 + 'px'" :height="window.height - 120 + 'px'" />
                    <v-btn fab x-large @click="mCapture" bottom class="text-center play-button" v-show="!isPhotoTaken">
                        <v-icon x-large color="primary">mdi-camera-outline</v-icon>
                    </v-btn>
                    <v-row v-show="isPhotoTaken" class="play-button">
                        <v-col cols="6">
                            <v-btn @click="savePicture" bottom class="text-center green white--text">
                                <v-icon class="mr-5">mdi-content-save</v-icon>
                                Save
                            </v-btn>
                        </v-col>
                        <v-col cols="6">
                            <v-btn @click="stopCameraStream" bottom class="text-center red white--text">
                                <v-icon class="mr-1">mdi-close</v-icon>
                                Discard
                            </v-btn>
                        </v-col>

                    </v-row>

                </div>

            </v-card-text>
        </v-card>

    </v-dialog>

</v-container>
</template>

<script>
export default {
    props:{
        OpenCam:{
            type: Boolean
        },
        editHeader:{
            type: Object
        },
        currentPanelNo:{
            type: String
        }
    },
    data: () => ({
        TableHeader: ['EMPLOYEE CODE', 'EMPLOYEE NAME', 'DEP/SEC/TEAM', 'USER LEVEL', 'ACTION'],
        SchedHeader: ['PANEL', 'QTY', 'TAKE'],
        Contents: [],
        isPhotoTaken: false,
        imageName: 'TRRYY',
        ischangeorientation: '',
        window: {
            width: '',
            height: ''
        }
    }),
    created() {
        this.mGetTable()
        console.log(window.matchMedia);
        this.window = {
            width: screen.width,
            height: screen.height,
            orientation: screen.width > screen.height ? 'Landscape' : 'Portrait'
        }
    },
    mounted() {
        this.detectOrientation();
        window.addEventListener('resize', this.detectOrientation);
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.detectOrientation);
    },
    watch: {
        ischangeorientation(val, val1) {
            if (val != val1) {
                this.isPhotoTaken = true
                this.isPhotoTaken = false
            }
        },
        OpenCam(val){
            if(val)
                this.createCamera()
        }
    },
    methods: {
        detectOrientation() {
            const isPortrait = window.matchMedia('(orientation: portrait)').matches;
            this.$emit('orientationChange', isPortrait);
            this.window = {
                width: screen.width,
                height: screen.height,
                orientation: screen.width > screen.height ? 'Landscape' : 'Portrait'
            }
            this.ischangeorientation = isPortrait
        },
        mGetTable() {
            axios.get(`api/master`)
                .then(res => {
                    this.Contents = res.data
                }).catch(({
                    response
                }) => {
                    this.$store.dispatch('setStatusCode', response.status)
                    this.$router.push('/error/' + response.status)
                })
        },
        // mTakePhoto() {
        //     this.OpenCam = true
        //     this.createCamera()

        // },
        mCapture() {
            // if (!this.isPhotoTaken) {

            //     this.OpenCam = true;
            //     setTimeout(() => {

            //     }, 2000);
            // }
            this.isPhotoTaken = !this.isPhotoTaken;
            const ctx = this.$refs.canvas.getContext("2d");
            ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);

            let newWidth = this.window.width - 45,
                newHeight = this.window.height - 120;
            // if (this.window.orientation == "Portrait") {

            //     newWidth = 950
            //     newHeight = Math.floor((newWidth / 4) * 3.2)
            // } else {

            //     newWidth = 1200
            //     newHeight = Math.floor((newWidth / 16) * 9)
            // }

            ctx.canvas.width = newWidth
            ctx.canvas.height = newHeight

            ctx.drawImage(this.$refs.camera, 0, 0, newWidth, newHeight); //portrait camera

        },
        savePicture() {
            const canvas = document.getElementById("photoTaken");
            canvas.toBlob((blob) => {
                let paramsObj = {};
                paramsObj.title = this.currentPanelNo
                paramsObj.path = "image"
                paramsObj.isretake = 0
                const file = new File([blob], this.imageName + '.jpg');
                const formData = new FormData();
                formData.append("file", file);
                formData.append("params", JSON.stringify(paramsObj));

                axios({
                        method: "POST",
                        url: `api/camera`,
                        data: formData,
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((res) => {
                        this.stopCameraStream()
                    })
                    .catch(({
                        response
                    }) => {
                        this.$router.push("/error/" + response.status);
                    });
            });
            // this.$store.commit('setItem', this.editHeader)
            this.$router.push('/view');
            location.reload()
        },

        createCamera() {
            const constraints = (window.constraints = {
                audio: false,
                video: {
                    facingMode: "environment"
                },
            })
            navigator.mediaDevices
                .getUserMedia(constraints)
                .then((stream) => {
                    this.$refs.camera.srcObject = stream
                })
                .catch((error) => {
                    alert("Error")
                })
        },
        stopCameraStream() {
            this.isPhotoTaken = false
            this.closeCam()
            let tracks = this.$refs.camera.srcObject.getTracks();
            tracks.forEach((track) => {
                track.stop();
            });
        },
        closeCam(){
            this.$emit("closecam")
        }
    }
}
</script>

<style>
.THeader {
    color: white !important;
    background-color: #3c282f;
}

.TableDesign {
    border: 1px solid black !important;
    border-collapse: collapse;
    text-align: center !important;
}

.SchedLabelInd {
    font-size: 2vw !important;
}

.donthover tr:hover {
    background-color: transparent !important;

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
</style>
