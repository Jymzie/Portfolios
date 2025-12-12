<template>
  <v-container fluid>
    <v-dialog v-model="buksancam" fullscreen persistent>
      <v-card flat color="black">
        <v-card-text>
          <div class="text-center video-container">
            <video
              v-show="!isPhotoTaken"
              class="video"
              ref="camera"
              autoplay
              :width="$vuetify.breakpoint.width-50 + 'px'"
              :height="$vuetify.breakpoint.height - 60 + 'px'"
            />
            <canvas
              v-show="isPhotoTaken"
              class="video"
              id="photoTaken"
              ref="canvas"
              :style="sCanvas()"
            />
            <v-btn
              fab
              x-large
              @click="mCapture"
              bottom
              class="text-center play-button"
              v-if="!isPhotoTaken && 
              (!isretake && (OpenCam-1)+photoarraycount != 8 &&
              !isaxiosload) ||
              (isretake && photoarraycount == 0 &&
              !isaxiosload) "
     
            >
           
              <v-icon x-large color="primary">mdi-camera-outline</v-icon>
            </v-btn>
            <v-btn :disabled="isaxiosload"  v-if="!isPhotoTaken && photoarraycount != 0" @click="savePicture" bottom class="mt-3 text-center green white--text">
                  <div v-if="!isaxiosload">
                    <v-icon  class="mr-5">mdi-content-save</v-icon>
                    Save
                  </div>
                 
                  <v-progress-circular indeterminate
      color="primary" size='30' style="padding: 0;margin: 0;" v-else ></v-progress-circular>
                  
                   
                </v-btn>
                <v-btn
                  @click="stopCameraStream"
                  v-if="!isPhotoTaken&&
                      !isaxiosload"
                  bottom
                  class="mt-3 text-center red white--text"
                >
                  <v-icon class="mr-1 ">mdi-close</v-icon>
                  Discard
                </v-btn>
          
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
export default {
  props: {
    OpenCam: {
      type: Number,
    },
    imagePath: {
      type: String,
    },
    editHeader: {
      type: Object,
    },
    currentPanelNo: {
      type: String,
    },
    isretake: {
      type: Boolean,
    },
  },
  data: () => ({
    // TableHeader: ['EMPLOYEE CODE', 'EMPLOYEE NAME', 'DEP/SEC/TEAM', 'USER LEVEL', 'ACTION'],
    // SchedHeader: ['PANEL', 'QTY', 'TAKE'],
    // Contents: [],
    isaxiosload: false,
    isPhotoTaken: false,
    imageName: "TRRYY",
    ischangeorientation: "",
    window: {
      width: "",
      height: "",
    },
    buksancam: false,
    photoarray:[],
    photoarraycount:0
  }),
  created() {
    this.window = {
      width: screen.width,
      height: screen.height,
      orientation: screen.width > screen.height ? "Landscape" : "Portrait",
    };
  },
  mounted() {
    this.detectOrientation();
    window.addEventListener("resize", this.detectOrientation);
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.detectOrientation);
  },
  watch: {
    ischangeorientation(val, val1) {
      if (val != val1) {
        this.isPhotoTaken = true;
        this.isPhotoTaken = false;
      }
    },
    OpenCam(val) {
      if (val){
        this.buksancam = true
        this.createCamera();
      } else
        this.buksancam = false
    },
  },

  computed: {
    sCanvas(){
      return {
        width: this.$vuetify.breakpoint.width-50 + 'px',
        height: this.$vuetify.breakpoint.height - 60 + 'px'
      }
    },
  },
  methods: {
   
    detectOrientation() {
      const isPortrait = window.matchMedia("(orientation: portrait)").matches;
      this.$emit("orientationChange", isPortrait);
      this.window = {
        width: screen.width,
        height: screen.height,
        orientation: screen.width > screen.height ? "Landscape" : "Portrait",
      };
      this.ischangeorientation = isPortrait;
    },
  

    mCapture() {
      this.isPhotoTaken = !this.isPhotoTaken;
      const ctx = this.$refs.canvas.getContext("2d");
      ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
      let newWidth = 3264 ,
        newHeight = 2448;
      
      if(this.ischangeorientation){
        newWidth = 2448,
        newHeight = 3264;
      }
        
      ctx.canvas.width = newWidth;
      ctx.canvas.height = newHeight;
      ctx.drawImage(this.$refs.camera, 0, 0, newWidth, newHeight); //portrait camera
      this.storePicture()
    },

    storePicture(state){
  
          const canvas = document.getElementById("photoTaken");
          canvas.toBlob((blob) => {
            const file = new File([blob], this.photoarraycount + ".jpg");
            this.photoarray[this.photoarraycount] = file
            this.isPhotoTaken = !this.isPhotoTaken
            this.photoarraycount++

         
          })
          
       

        
        
    },
    savePicture() { 
        this.isaxiosload = true
        let paramsObj = {};
        paramsObj.title = this.currentPanelNo;
        paramsObj.path = this.imagePath;
        paramsObj.isretake = this.isretake;
        paramsObj.count = this.photoarray.length;
        const formData = new FormData();
        for(let x=0; x<this.photoarray.length; x++){
          formData.append("file"+x, this.photoarray[x]);

          // NOTE Download 
          // const url = window.URL.createObjectURL(new Blob([this.photoarray[x]]))
          // const link = document.createElement("a");
          // link.href = url
          // link.setAttribute("download", this.currentPanelNo.slice(0, 6)+'_'+(Number(this.currentPanelNo[7])+x)+'.jpg')
          // document.body.appendChild(link)
          // link.click();
          // link.remove();
        }
          
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
            if (res.data == 1) {
              this.$emit("loadsave", this.currentPanelNo);
              this.$swal
                .fire({
                  title: "Image successfully saved",
                  icon: "success",
                  showConfirmButton: false,
                  timer: 1000,
                })
              
                // .finally(() => {
                 // if (window.location.pathname == "/NPS/view") {
                    // if (this.isretake) location.reload();
                    // else 
                    // this.isaxiosload = false
                    // this.$emit("gettable");
                 // } else this.$router.push("/view");
                 
                // });
            } else {
              this.$swal.fire({
                title: "Failed to save image",
                icon: "error",
                showConfirmButton: false,
                timer: 1000,
              });
            }

            this.stopCameraStream();
          })
          .catch(({ response }) => {
            this.$swal.fire({
              title: "Failed to save image",
              icon: "error",
              showConfirmButton: false,
              timer: 1000,
            });
          })
          .finally(() => {
              this.isaxiosload = false
              this.$emit("gettable");
          })
          
    },

    createCamera() {
      this.isaxiosload = true;
      const constraints = (window.constraints = {
        audio: false,
        video: {
          facingMode: "environment",
           "width": {
              "ideal": 3264
            },
            "height": {
              "ideal": 2448
            }
        },
      });
      navigator.mediaDevices
        .getUserMedia(constraints)
        .then((stream) => {
          this.isaxiosload = false
          this.$refs.camera.srcObject = stream;
        })
        .catch((error) => {
          alert("Error");
        });
    },
    stopCameraStream() {

      
      this.closeCam();
      let tracks = this.$refs.camera.srcObject.getTracks();
      tracks.forEach((track) => {
        track.stop();
      });
      setTimeout(() => {
        this.photoarray = []
        this.photoarraycount = 0
        this.isPhotoTaken = false;
      }, 1000);
      
    },
    closeCam() {
      this.$emit("closecam");
    },
  },
};
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
