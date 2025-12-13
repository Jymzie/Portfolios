<template>
<v-container fluid fixed>
    <!-- <v-btn style="margin-left: 15px;" absolute right fab small color="black" @click="$router.push('monitoring')">
        <v-icon color="white">mdi-close</v-icon>
    </v-btn> -->

    <h2 class="mb-4" >SAMPLE MONITORING</h2>
    <!-- <h2 class="mb-4" v-else-if="$store.state.details.Process == 2">GLASS CHECKING AND FRAMING</h2>
    <h2 class="mb-4" v-else-if="$store.state.details.Process== 3">CUTTING</h2>

    <h2 class="mb-4" v-else-if="$store.state.details.Process== 4">BORING / HOLING</h2>
    <h2 class="mb-4" v-else-if="$store.state.details.Process== 5">MARKING AND MANUAL BORING</h2>
    <h2 class="mb-4" v-else-if="$store.state.details.Process== 6">UNIT ASSEMBLY & GLASS FITTING</h2>
    <h2 class="mb-4" v-else-if="$store.state.details.Process== 7">UNIT PACKING</h2>
    <h2 class="mb-4" v-else-if="$store.state.details.Process== 8">GLASS CLEANING AND PACKING</h2> -->

    <v-card style="border: 1px solid black; ">
        <v-card-text>
            <v-row>
                <v-col cols="7" md="10" sm="8">
                    <v-row>
                        <v-col cols="12" md="3" sm="6">
                            <h4  >HOUSE CODE</h4>
                            <v-text-field dense outlined readonly v-model="lPlaceholder"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="3" sm="6">
                            <h4  :style="$vuetify.breakpoint.xsOnly ? 'margin-top:-50px':''">CUSTOMER CODE</h4>
                            <v-text-field dense outlined readonly  v-model="lPlaceholder"></v-text-field>
                        </v-col>
                    
                        <v-col cols="12" md="3" sm="6">
                            <h4  :style="$vuetify.breakpoint.smAndDown ? 'margin-top:-50px':''">HINBAN</h4>
                            <v-text-field dense outlined readonly v-model="lPlaceholder"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="3" sm="6">
                            <h4  :style="$vuetify.breakpoint.smAndDown ? 'margin-top:-50px':''">REQUEST</h4>
                            <v-text-field dense outlined readonly  v-model="lPlaceholder"></v-text-field>
                        </v-col>
                        <!-- <v-col cols="4">
                            <v-card color="#CC0000" style="transform:translatey(-40%);border-radius: 15px 15px 15px 15px; border: solid black; z-index:2;">
                                <v-card-subtitle style="font-size: 1.4vw;" class="white--text mt-n2 ">STATUS</v-card-subtitle>
                                <v-card-text class="white--text text-center mt-2">
                                    <span style="font-size: 3vw;">{{ mStatusCount }}/{{TableData.length}}</span>
                                </v-card-text>
                            </v-card>
                        </v-col> -->
                    </v-row>
                      
                
                </v-col>
                <v-col cols="5" md="2" sm="4">
                    <v-card color="#CC0000" style="transform:translatey(-40%);border-radius: 15px 15px 15px 15px; border: solid black; z-index:2;">
                                <v-card-subtitle class="white--text mt-n2 ">STATUS</v-card-subtitle>
                                <v-card-text class="white--text text-center mt-2">
                                    <span style="font-size: 30px;">{{ mStatusCount }}/{{TableData.length}}</span>
                                </v-card-text>
                            </v-card>
                </v-col>

            </v-row>
            <hr class="mt-n8 mb-2">
            <v-card class="grey lighten-1">
                <v-card-text >
                    <AccessoriesVue :AccessoriesTableData="TableData" :mOpenConfirmation="mOpenConfirmation" :mCheckFlg="mCheckFlg" :mRemark="mRemark" :ForConfirmationData="ForConfirmationData"/>
                </v-card-text>
                <!-- <v-card-text v-else-if="$store.state.details.Process == 5">
                    <MarkingAndManualBoringVue :MarkingTableData="TableData" :mOpenConfirmation="mOpenConfirmation" :mCheckFlg="mCheckFlg" :mRemark="mRemark" :ForConfirmationData="ForConfirmationData" :TypeTotal="TypeTotal" :TypeDone="TypeDone" :CurrentType="CurrentType" :mPrev="mPrev" :mNext="mNext" :type="Selectiontype" />
                </v-card-text>
                <v-card-text v-else-if="$store.state.details.Process == 6">
                    <UnitAssembly :UnitAssemblyTableData="TableData" :mOpenConfirmation="mOpenConfirmation" :mCheckFlg="mCheckFlg" :mRemark="mRemark" :TypeTotal="TypeTotal" :TypeDone="TypeDone" :CurrentType="CurrentType" :mPrev="mPrev" :mNext="mNext" :type="Selectiontype" :ForConfirmationData="ForConfirmationData"/>
                </v-card-text>
                <v-card-text v-else-if="$store.state.details.Process == 2 ">
                    <GlassCheckingAndFramingVue :GlasscheckingAndFramingTableData="TableData" :mOpenConfirmation="mOpenConfirmation" :mCheckFlg="mCheckFlg" :mRemark="mRemark" :ForConfirmationData="ForConfirmationData"/>
                </v-card-text>

                <v-card-text v-else-if="$store.state.details.Process == 3">
                    <CuttingVue :CuttingTableData="TableData" :mOpenConfirmation="mOpenConfirmation" :mCheckFlg="mCheckFlg" :mRemark="mRemark" :TypeTotal="TypeTotal" :TypeDone="TypeDone" :CurrentType="CurrentType" :mPrev="mPrev" :mNext="mNext" :type="Selectiontype" :ForConfirmationData="ForConfirmationData" />
                </v-card-text>

                <v-card-text v-else-if="$store.state.details.Process == 7">
                    <UnitPackingVue :UnitPackingTableData="TableData" :mOpenConfirmation="mOpenConfirmation" :mCheckFlg="mCheckFlg" :mRemark="mRemark" :TypeTotal="TypeTotal" :TypeDone="TypeDone" :CurrentType="CurrentType" :mPrev="mPrev" :mNext="mNext" :type="Selectiontype" :ForConfirmationData="ForConfirmationData" />
                </v-card-text>

                <v-card-text v-else-if="$store.state.details.Process == 4">
                    <BoringHolingVue :BoringHolingTableData="TableData" :mOpenConfirmation="mOpenConfirmation" :mCheckFlg="mCheckFlg" :mRemark="mRemark" :ForConfirmationData="ForConfirmationData"/>
                </v-card-text>

                <v-card-text v-else-if="$store.state.details.Process == 8">
                    <GlassCleaningandPackingVue :GlassArrData="glassarr" :FrameArrData="framearr" :QtyArrData="qtyarr" :mOpenConfirmation="mOpenConfirmation" :mCheckFlg="mCheckFlg" :mRemark="mRemark" :ForConfirmationData="ForConfirmationData"/>
                </v-card-text> -->
            </v-card>

        </v-card-text>

    </v-card>

    <v-dialog v-model="ListDialog" persistent width="40%">
        <v-card>
            <v-card-title>Plan List
                <v-spacer />
                <v-btn fab x-small color="black" @click="ListDialog = !ListDialog">
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-simple-table fixed-header height="400">
                    <tbody>
                        <tr v-for="(item,i) in MonitoringData" :key="i">
                            <td class="TableBorders" style="text-align: right">{{item.Seq}}</td>
                            <td class="TableBorders" style="text-align: left">{{item.NameCD}}</td>
                            <td class="TableBorders">{{item.Hinban}}</td>
                            <td class="TableBorders">

                                <v-tooltip right>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn x-small v-on="on" v-bind="attrs" color="#FA6800" class="py-5" @click="ListDialog = !ListDialog">
                                            <v-icon color="#FFFFFF">mdi-play</v-icon>
                                        </v-btn>
                                    </template>
                                    <span class="spancolor">Select Plan</span>
                                </v-tooltip>

                            </td>
                        </tr>
                    </tbody>
                </v-simple-table>
            </v-card-text>

        </v-card>
    </v-dialog>

    <v-container :fluid="true">

        <v-row class="mt-1" style="margin:auto; padding:auto;" align="center" justify="center">
            <v-col cols="4" sm="2">
                <v-row>

                    <v-col cols="6">
                        <v-btn class="ml" width="100%" min-width="100%" color="#647687">
                            <v-icon class="white--text">mdi-flip-h mdi-play</v-icon>
                        </v-btn>
                    </v-col>
                    <v-col cols="6"></v-col>
                </v-row>

            </v-col>

            <v-col cols="4" sm="5">
                <v-row>
                    <!-- <v-col cols="4"> -->
                        <v-btn width="100%" min-width="100%" >{{lPlaceholder}}</v-btn>
                    <!-- </v-col>
                    <v-col cols="4">
                        <v-btn width="100%" min-width="100%" class="paginationfont">{{lPlaceholder}}</v-btn>
                    </v-col>
                    <v-col cols="4">
                        <v-btn width="100%" min-width="100%" class="paginationfont">{{lPlaceholder}}</v-btn>
                    </v-col> -->
                </v-row>

            </v-col>

            <v-col cols="4" sm="2">
                <v-row>
                    <v-col cols="6">
                        <v-btn width="100%" min-width="100%" color="#647687" @click="ListDialog = !ListDialog">
                            <v-icon class="white--text">mdi-dots-horizontal</v-icon>
                        </v-btn>
                    </v-col>
                    <v-col cols="6">
                        <v-btn width="100%" min-width="100%" color="#647687">
                            <v-icon class="white--text">mdi-play</v-icon>
                        </v-btn>
                    </v-col>

                </v-row>

            </v-col>

        </v-row>

    </v-container>
    <v-dialog v-model="ConfirmationDialog" persistent :fullscreen="$vuetify.breakpoint.xsOnly" :width="$vuetify.breakpoint.xsOnly ? '':$vuetify.breakpoint.mdOnly ? '40%': $vuetify.breakpoint.smOnly ? '50%':'30%'">
        <v-card>
            <v-card-title>
                <h4>For Confirmation Log</h4>
                <v-spacer />

                <v-btn fab x-small color="black" @click="ConfirmationDialog = mCloseConfirmation()">
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>

            </v-card-title>
            <v-card-text>
                <textarea v-model="Remark.Remark" style="background-color:#D5E8D4; width:100%; height:100px; resize:none;border-radius:5px;font-size:20px;padding:10px;"></textarea>

            </v-card-text>
            <v-card-actions class="mt-n5 mr-2">
                <v-spacer />
                <v-btn color="#647687" style="align:right" class="white--text" :disabled='Remark.Remark == null || Remark.Remark == ""' @click="mRemark">SAVE</v-btn>
            </v-card-actions>

        </v-card>
    </v-dialog>

    <v-dialog v-model="isLoading" persistent width="300" content-class="elevation-0">
        <img src="/BHM/images/loading.gif">
    </v-dialog>

</v-container>
</template>

<script>
import AccessoriesVue from './Accessories.vue'
// import UnitAssembly from './UnitAssembly.vue'
// import UnitPackingVue from './UnitPacking.vue'
// import GlassCheckingAndFramingVue from './GlassCheckingAndFraming.vue'
// import BoringHolingVue from './BoringHoling.vue'
// import MarkingAndManualBoringVue from './MarkingAndManualBoring.vue'
// import CuttingVue from './Cutting.vue'
// import GlassCleaningandPackingVue from './GlassCleaningandPacking.vue'

export default {
    components: {
        AccessoriesVue,
        // UnitAssembly,
        // UnitPackingVue,
        // GlassCheckingAndFramingVue,
        // BoringHolingVue,
        // MarkingAndManualBoringVue,
        // CuttingVue,
        // GlassCleaningandPackingVue
    },
    data() {
        return {
            Header: ['STATUS', 'QTY', 'UNIT', 'ITEM NAME', ''],
            AccessoriesTableData: [],
            TableData: [{CheckedFlg: "0", Qty: "3.00", Unit: "pcs", ItemName: "SAMPLE 1", CtrlID:"1"},
                    {CheckedFlg: "0", Qty: "7.00", Unit: "pcs", ItemName: "SAMPLE 2" , CtrlID:"2"},
                    {CheckedFlg: "0", Qty: "1.00", Unit: "pcs", ItemName: "SAMPLE 3", CtrlID:"3"},
                    {CheckedFlg: "0", Qty: "4.00", Unit: "pcs", ItemName: "SAMPLE 4", CtrlID:"4"},
                    {CheckedFlg: "0", Qty: "10.00", Unit: "pcs", ItemName: "SAMPLE 5", CtrlID:"5"}],
            glassData: [],
            Remark: {},
            ConfirmationDialog: false,
            ListDialog: false,
            StatusCount: 0,
            // details: this.$store.state.details,
            // Date: this.$store.state.Date,
            type: '',
            // page: this.$store.state.planpage,
            prevplan:'',
            nextplan:'',
            thisplan:'',
            lPlaceholder: 'XXXX-XX',
            // userinfo: this.$store.state.userinfo,
            Selectiontype: [{
                    Name: 'TOPRAIL',
                    Value: 2
                },
                {
                    Name: 'BOTTOMBAR',
                    Value: 3
                },
                {
                    Name: 'PANEL STOPPER',
                    Value: 4
                }
            ],
            CurrentType: 0,
            MonitoringData: [{Seq: 1, NameCD:"XXXX-XX", Hinban:'XXXX-XX'}, {Seq: 2, NameCD:"XXXX-XX", Hinban:'XXXX-XX'}, {Seq: 3, NameCD:"XXXX-XX", Hinban:'XXXX-XX'}],
            ForConfirmationData: [],
            maxpagelist: 0,
            isLoading: false,
            glassarr: [],
            framearr: [],
            qtyarr: [],

        }
    },
    created() {
        this.mSetPlan()
        // this.getForConfirmation()
        // this.page = this.$store.state.planpage
    },

    methods: {
        mpagenext() {
            this.$store.commit('setCDNO', this.thisplan[0].CDNo)
            this.ForConfirmationData = [];
            this.TableData = [];
            this.page++
            this.mJumpPlan()
        },
        mpageprev() {
            this.$store.commit('setCDNO', this.thisplan[0].CDNo)
            this.ForConfirmationData = [];
            this.TableData = [];
            this.page--
            this.mJumpPlan()
        },
        mSpecificPlan(item) {
            this.page = item.Seq - 1
            this.mJumpPlan()
            this.ListDialog = false
        },
        mJumpPlan() {
            this.$store.commit('setPlanPage', this.page)
            this.mSetList()
            // this.$store.commit('setCDNO', this.thisplan[0].CDNo)
        },
        mSetPlan() {
            // if (this.$store.state.details.Process == 1)
                this.type = 'accessories'
            // else if (this.$store.state.details.Process == 2)
            //     this.type = 'glasscheckingandframing'
            // else if (this.$store.state.details.Process == 3)
            //     this.type = 'cutting'
            // else if (this.$store.state.details.Process == 5)
            //     this.type = 'marking'
            // else if (this.$store.state.details.Process == 7)
            //     this.type = 'unitpacking'
            // else if (this.$store.state.details.Process == 4)
            //     this.type = 'boringholing'
            // else if (this.$store.state.details.Process == 6)
            //     this.type = 'unitassembly'
            // else if (this.$store.state.details.Process == 8)
            //     this.type = 'glasscleaningandpacking'
            // this.mSetList()

        },
        mSetList() {     
            this.isLoading = true             
            if (this.type == 'marking' || this.type == 'cutting' || this.type == 'unitpacking' || this.type == 'unitassembly' || this.type == 'boringholing') {
                this.mSetPartType()
            }
            // this.prevplan = this.MonitoringData.filter(rec => rec.Seq == this.$store.state.planpage)
            this.thisplan = this.MonitoringData.filter(rec => rec.Seq == this.$store.state.planpage+1)
            // this.nextplan = this.MonitoringData.filter(rec => rec.Seq == this.$store.state.planpage+2)
            axios.get(`${this.$url}/api/${this.type}?Hinban=${this.thisplan[0].Hinban}&&NameCD=${this.thisplan[0].NameCD}&&Week=${this.details.Week}&&Year=${this.details.Year}&&EmpID=${this.$store.state.userinfo.EmployeeNo}`)
                .then(res => {
                    this.TableData = res.data;
                    let data = this.TableData
                    // let glass = data.filter(holder => holder.CtrlID === "1");
                    // let frame = data.filter(holder => holder.CtrlID === "2");
                    // let qty = data.filter(holder => holder.CtrlID === "3");
                    // this.glassarr = glass;
                    // this.framearr = frame;
                    // this.qtyarr = qty;
               
                    // end khaim
                }).catch(response => {
                    if(!response.status == 200){
                        this.$store.dispatch('setStatusCode', response.status)
                       this.$router.push('/error/' + response.status)
                    }
                }).finally(() => {
                    this.Selectiontype = this.Selectiontype.filter(rec => this.TableData.some(req => req.CtrlID == rec.BalconyPartTypeID))
                    this.isLoading = false
                    // this.mStatusCount()
                })
              
        },
        mSetPartType() {
            axios.get(`${this.$url}/api/balconytype`)
                .then(res => {
                    this.Selectiontype = res.data
                }).catch(response   => {
                    if(!response.status == 200){
                        this.$store.dispatch('setStatusCode', response.status)
                       this.$router.push('/error/' + response.status)
                    }
                })
        },
        mOpenConfirmation(item) {
            this.ConfirmationDialog = true
            this.Remark = item

        },
        mCloseConfirmation() {
            this.Remark.Remark = ''
            this.ConfirmationDialog = false
        },
        
   
        mCheckFlg(item) {   
            //  if (this.CheckFlgMethod != 'remarks') {
            //     item.NameCD = this.MonitoringData[this.page].NameCD
            //     item.Hinban = this.MonitoringData[this.page].Hinban
            //     item.Week = this.$store.state.Date.Week
            //     item.Year = this.$store.state.Date.Year
            //     item.EmployeeNo = this.userinfo.EmployeeNo
            // }
            if(item.CheckedFlg == 0)
                item.CheckedFlg = 1
            else
                item.CheckedFlg = 0
            // axios.patch(`${this.$url}/api/${this.type}/${this.CheckFlgMethod}`, this.CheckFlgMethod == 'remarks' ? this.Remark : item)
            //     .then(res => { 
            //         this.TableData = res.data['data'];
            //         this.ForConfirmationData = res.data['confirmations'];
            //         let data = this.TableData
            //         let glass = data.filter(holder => holder.CtrlID === "1");
            //         let frame = data.filter(holder => holder.CtrlID === "2");
            //         let qty = data.filter(holder => holder.CtrlID === "3");
            //         this.glassarr = glass;
            //         this.framearr = frame;
            //         this.qtyarr = qty;
                    // this.$socket.emit('reload_data', {plan:this.thisplan,req:this.$store.state.header})
                    // this.mStatusCount();
                //   })
          
            
        },
        mRemark() {
            // this.CheckFlgMethod = 'remarks'
            // this.Remark.NameCD = this.MonitoringData[this.page].NameCD
            // this.Remark.Hinban = this.MonitoringData[this.page].Hinban
            // this.Remark.Week = this.$store.state.Date.Week
            // this.Remark.Year = this.$store.state.Date.Year
            // this.Remark.EmployeeNo = this.userinfo.EmployeeNo
            // this.mCheckFlg()
            this.Remark.CheckedFlg = 3
            // console.log(this.TableData, this.Remark)
            let thisremark = {Remarks: this.Remark.Remark, CtrlID:this.Remark.CtrlID}
            this.ForConfirmationData.push(thisremark)
            this.Remark = {}
            // this.CheckFlgMethod = 'checkflg'
            this.ConfirmationDialog = false
            // this.mSetList()
        },

 
        mPrev() {
            this.CurrentType--
        },
        mNext() {
            this.CurrentType++
        },
        getForConfirmation() {
            axios.get(`api/forconfirmation`)
                .then((res) => {
                    this.ForConfirmationData = res.data;
                })
                .catch(({
                    response
                }) => {
                    this.$router.push("/error/" + response.status);
                }).finally(() => {
                    this.maxpagelist = this.MonitoringData.length
                })
        },
      
    },
    computed: {
        mStatusCount() {
                this.StatusCount = 0
                for (let x = 0; x < this.TableData.length; x++) {
                    if (this.TableData[x].CheckedFlg == 1)
                    this.StatusCount++
                }
                return this.StatusCount
            },
  
        TypeTotal() {
            return this.TableData.filter(rec =>
                 rec.Type.includes(this.Selectiontype[this.CurrentType].BalconyPartTypeName)).length

        },
        TypeDone() {
            return this.TableData.filter(rec => rec.Type.includes(this.Selectiontype[this.CurrentType].BalconyPartTypeName) && rec.CheckedFlg == 1).length
        }
    }
}
</script>

<style>
.TableDesign {
    border: 1px solid black !important;
    border-collapse: collapse;
    text-align: center;
    font-size: 20px !important;
    height: 100% !important;
    font-weight: bold;
    white-space: nowrap;
}

.TableDesign .actionButtons {
    visibility: hidden;
}

tr:hover .TableDesign .actionButtons {
    visibility: visible;
}

tr:hover {
    background: #ffd4ac !important;
}

.BlackBorder {
    border: 1px solid black;
}

.full-screen-div {
    width: 80vw;
    height: 80vh;
    margin: 10vh auto;
}

.v-tooltip__content {
    opacity: 1 !important;
}

.paginationfont {
    font-weight: bold;
    font-size: 1.1vw !important;
    pointer-events: none
}
</style>
