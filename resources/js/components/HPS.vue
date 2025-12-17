<template>
   <div>
    <!-- This system are responsible for setting schedule of the demado, arch wall, porch materials for process of GT materials and sending to the HTI Ordering System -->
  
        <div class="pb-2">
              <b class="Maroontext Titlesize">SCHEDULE</b>
        </div>
        <div class="absoluteright" style="padding: 0 5px 0 0;">
          <v-btn @click="isshowsearch = !isshowsearch">
                <v-icon>{{ isshowsearch ? 'mdi-chevron-up':'mdi-chevron-down' }}</v-icon>
              </v-btn>
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-btn @click="adddialog = !adddialog" v-bind="attrs" v-on="on">
              <v-icon>
                mdi-file-export
              </v-icon>
            </v-btn>
          </template>
          <span>Export Summary</span>
        </v-tooltip>    
        
        </div>
        
        <!-- ANCHOR request -->
        <v-card class="mb-2" color="#e9c9aa" v-if="isshowsearch">
            <v-card-text>
             
                  <div :class="!$vuetify.breakpoint.xsOnly ? 'search-grid-container':''" 
                :style="$vuetify.breakpoint.smOnly ? 'width:70%':!$vuetify.breakpoint.xsOnly ? 'width:50%':''">
                    <div class="titlegrid pb-2"><b class="Maroontext">REQUEST</b></div>
                    <div class="fromgrid mb-n4">
                        <v-autocomplete label="FROM" @blur="mAutoFill($event,'from')" clearable maxlength="9" oninput="this.value = this.value.replace(/[^a-zA-Z0-9-]/g, '')" v-model="from" :items="Request" item-text="Request" item-value="Priority" :error-messages="searcherr.from" background-color="white" outlined dense></v-autocomplete>
                    </div>
                    <div class="togrid mb-n4">
                        <v-autocomplete label="TO" @blur="mAutoFill($event,'to')" clearable maxlength="9" oninput="this.value = this.value.replace(/[^a-zA-Z0-9-]/g, '')" v-model="to" :items="ToList" item-text="Request" item-value="Priority" :error-messages="searcherr.to" background-color="white" dense outlined></v-autocomplete>
                    </div>
                    <div class="searchgrid pb-1">
                        <v-btn @click="mSearch"><span class="Maroontext buttonsmcaps">Search</span></v-btn>
                    </div>
                  
                    
                </div>
               
                
              
               
                
            </v-card-text>
        </v-card>

        <!-- ANCHOR filter -->
        <v-card class="mb-3" color="#e9c9aa" v-if=isshowsearch>
            <v-card-text>
                <div :class="$vuetify.breakpoint.smOnly ? 'filter-grid-container-sm':!$vuetify.breakpoint.xsOnly ? 'filter-grid-container':''">
                    <div class="titlegrid pb-2"><b class="Maroontext">FILTER</b></div>
                    <div class="linegrid mb-n4">
                        <v-autocomplete label="Line" clearable maxlength="10" oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')" v-model="filter.line" :items="LineList" background-color="white" dense outlined></v-autocomplete>
                    </div>
                    <div class="reqgrid mb-n4">
                        <v-autocomplete label="RequestCode" clearable maxlength="2" oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')"  v-model="filter.req" :items="ReqCode" background-color="white" dense outlined></v-autocomplete>
                    </div>
                    <div class="destgrid mb-n4">
                        <v-autocomplete label="DestinationCode" clearable maxlength="2" oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '')" v-model="filter.dest" :items="DestinationContent" item-text="DestinationCode" item-value="DestinationCode" background-color="white" dense outlined></v-autocomplete>
                    </div>
                
                    <div class="schedulegrid mb-n4">
                    <!-- NOTE scheduledate menudatepicker  -->
                      <template >
                        <v-menu
                        ref="menu1"
                        v-model="menu1"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="auto"
                        >
                            <template v-slot:activator="{ on }">
                            <v-text-field
                                clearable
                                v-model="dateFormatted"
                                label="ScheduledDate"
                                dense 
                                background-color="white"
                                outlined
                                readonly
                                @change="filter.sched = parseDate(dateFormatted)"
                                v-on="on"
                            ></v-text-field>
                            </template>
                            <v-date-picker v-model="filter.sched"  no-title @input="menu1 = false"></v-date-picker>
                        </v-menu>
                      </template>
                
                    </div>

                    <div class="notschedgrid pb-1 mt-2" @click="filter.nosched = !filter.nosched">
                        <input type="checkbox" :checked="filter.nosched">
                        <label>Not Scheduled</label>
                    </div>
                    <div class="cleargrid">
                        <v-btn @click="filter={dest:null,sched:null,nosched:false,line:null,req:null}">
                          <span class="Maroontext buttonsmcaps" dense>Clear</span>
                        </v-btn>
                    </div>
                </div>
            </v-card-text>
        </v-card>

        <!-- ANCHOR function button -->
        <div style="position: relative;" class="mb-3">
          <div class="pl-1" :class="!$vuetify.breakpoint.xsOnly ? 'function-grid-container':'function-grid-container-xs'">
            <div class="printgrid pb-1">
                <v-btn @click="mPrinting('print')" block>

                  <span class="Maroontext buttonsmcaps">Print</span>
                  <v-progress-circular
                    color="#3c282f"
                    indeterminate
                    class="ml-3"
                    :size="20"
                    v-if="isPrinting == true"/>
                </v-btn>
            </div>
            <div class="exportgrid pb-1">
                <v-btn @click="mPrinting('export')" block >
                 
                  <span class="Maroontext buttonsmcaps">Export</span>
                  <v-progress-circular
                    color="#3c282f"
                    indeterminate
                    class="ml-3"
                    :size="20"
                    v-if="isExporting == true"/>
                </v-btn>
            </div>
            <div class="tilegrid pb-1">
                <v-btn  @click="mPrinting('tile')" block><span class="Maroontext buttonsmcaps">Tile Cutting Checklist</span></v-btn>
            </div>
            <div class="setschedgrid mb-n4" v-if="$vuetify.breakpoint.xsOnly">
           
              <date-picker v-model="newDate" value-type="YYYY-MM-DD"  format="YYYY/MM/DD" placeholder="SetScheduleDate"></date-picker>
            </div>
            <div class="savegrid" v-if="$vuetify.breakpoint.xsOnly">
                <v-btn @click="mEditSched()">
                    <v-icon>
                        mdi-content-save
                    </v-icon>
                </v-btn>
            </div>
        </div>
        <tr class="absoluteright" v-if="!$vuetify.breakpoint.xsOnly">
          <td class="pr-2">

           <date-picker v-model="newDate" value-type="YYYY-MM-DD"  format="YYYY/MM/DD" placeholder="SetScheduleDate"  
            :style="$vuetify.breakpoint.smOnly ? 'width:130px':''"></date-picker>
          </td>
          <td>
               <v-btn @click="mEditSched()" >
                    <v-icon>
                        mdi-content-save
                    </v-icon>
                </v-btn>  
          </td>
        </tr>
        </div>
      
        

        <!-- ANCHOR Table  -->
        
        <v-simple-table class="text-center mt-1" fixed-header :height="$vuetify.breakpoint.mdAndUp && isshowsearch ? $vuetify.breakpoint.height - 340 + 'px': $vuetify.breakpoint.mdAndUp ? $vuetify.breakpoint.height - 180 :300">
          <v-row  class="text-center mt-10" v-if="isSchedLoading">
              <v-col cols="12">
                  <h3>Loading Schedule</h3>
              </v-col>
              <v-col cols="12">
                  <v-progress-circular loadingTable :size="90" :width="20" color="#3c282f" indeterminate></v-progress-circular>
              </v-col>
          </v-row>
          <div v-else-if="cSched.length == 0" class="text-center">
            <h1 class="promptempty">Schedule is empty!</h1>
          </div>
          <template v-else >
            <thead >
                <tr >
                    <th class="text-center marbeige" 
                      v-for="(header,i) in TableHeader" :key="i"
                      :rowspan="header == 'ConstructionCd/HouseCd'  ? '1':'2'"
                      :colspan="header == 'Request' || header == 'ConstructionCd/HouseCd' || header == 'Scheduled Date' ? '2': header == 'Unit Name' ? '6':'1'">{{ header }}</th>
                </tr>
                <tr>
                  <th class="text-center marbeige" colspan="2" >ReceivedDate</th>
                </tr>
                
            </thead>
           
            <tbody>

              
                <template v-for="(data) in cSched">
                  <tr>
                    <td class="BLU">{{ data.Priority}}</td>
                    <td class="BLU">{{ data.REQUEST}}</td>
                    <td>{{ data.ProductionId}}</td>
                    <td class="GRN">{{ data.CDNO}}</td>
                    <td class="GRN">{{ data.NameCode}}</td>
                    <td class="GRN">{{ data.PRODUCT_DATE}}</td>
                    <td class="YLW">{{ data.WINDOWTYPE}}</td>
                    <td class="YLW">{{ data.Exist}}</td>
                    <td class="YLW" colspan="3">{{ data.MAT_NAME}}</td>
                    <td class="YLW" colspan="3">{{ data.cUNIT}}</td>
                    <td class="YLW">{{ data.MAT_ELE_VALUE}}</td>
                    <td style="min-width: 125px;max-width: 125px;">     
                        <!-- <span v-if="data.ProductionId == undefined">UN</span> -->
                        <v-autocomplete class="no-underline" dense v-model="data.Line" :readonly="disableinputctrl" style="margin: -10px 0 -25px 0;" 
                        :items="LineList" @change="mEditLine(data)"/>
                    </td>
                    <td>
                      <span v-if="data.Line == undefined"></span>
                      <date-picker v-else :clearable="false" class="datepicker-noborder" v-model="data.ProductionScheduledDate" :disabled="disableinputctrl" value-type="YYYY-MM-DD"  format="YYYY/MM/DD" style="width: 130px;border: none; outline: none;"  @change="mEditSched(data)"></date-picker>
                      <!-- <input type="date" :value="data.ProductionScheduledDate"  style="width: 100px;" 
                         @blur="mEditSched(data,$event.target.value)" @keypress.enter="mEditSched(data,$event.target.value)"/> -->
                    </td>
                    <td style="width: 50px;" :style="data.ProductionId != undefined && pOrderclicked == data.ProductionId ? 'background-color:#EBFFD8':''">
                     
                      <span v-if="data.ProductionOrder == undefined"></span>
                      <v-text-field v-else class="no-underline" dense @click="pOrderclicked=data.ProductionId"  maxlength="2" :readonly="disableinputctrl" :value="data.ProductionOrder" style="width: 20px;margin: -15px 0 -23px 0;" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" @change="mEditOrder(data,$event)" @blur="pOrderclicked = null"/>
                    </td>
                  </tr>
                  <tr style="background-color:  #e6e6e6;">
                    <td style="background-color: white;"></td>
                    <td :style="data.Request_2 ? 'background-color:#ffcc99;color:red;':''">{{ data.Request_2}}</td>
                    <td>{{ data.Canceled ? 'Canceled':'' }}</td>
                    <td >{{ data.RECEIVED_DATE}}</td>
                    <td :style="data.ReceivedDate ? 'background-color:#ff99cc;':''">{{ data.ReceivedDate}}</td>
                    <td>{{ data.WallPanel }}</td>
                    <td>{{ data.SHIPMENT }}</td>
                    <td>{{ data.STYLE }}</td>
                    <td>1F</td>
                    <td>{{data.WINDOWCOLOR}}</td>
                    <td>{{data.ALARM}}</td>
                    <td>2F</td>
                    <td>{{data.WINDOWCOLOR2F}}</td>
                    <td>{{data.ALARM2F}}</td>
                    <td></td>
                    <td>Sash</td>
                    <td></td>
                    <td></td>
                  </tr>
                 
                </template>
               
             
                
            </tbody>
          </template>    
        </v-simple-table>

        <!-- ANCHOR Export Summary  -->
        <v-dialog v-model="adddialog" :width="this.$vuetify.breakpoint.smOnly ? '60%':'27%'" >
            <v-card style="background-color:#E9C9AA" fixed  class="mt-n3 text-center  pr-n10 ">
               
                <v-card-title style="background-color: #5A0A0A; color: #E9C9CC; font-weight: bold ; height:80px;" class="mb-n5 " >
                    {{'Export Summary'}}
                    <v-spacer/>
                    <v-icon style="color: red; font-weight: bold" @click="mCloseAdd()">mdi-close</v-icon>
                </v-card-title>
                <v-card-text   class="mt-5 text-center"  >
                    <v-row   class="mb-n5">
                        <v-col cols="3" lg="3" md="3" class="ma-0" dense >
                           <v-text-field      class="ma-0"                               
                                    v-model="additems.ww"
                                    maxlength = '2'
                                    outlined 
                                    dense   
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"                           
                                    style="z-index: 100; background-color: white; height:40px; 
                                    border: 1px solid;border-radius: 0px;" 
                                    label="WW" 
                                    :error-messages="wwerr == '' ? '':wwerr"
                            >                         
                           </v-text-field>
                        </v-col>

                        <v-col  dense class="mt-2 mr-n13 ml-n13" >
                            <span x-large class="mt-5"><h2>-</h2></span>
                        </v-col>
                        <v-col cols="3" lg="3" md="3" class="ma-0" dense >
                            <v-text-field outlined  dense class="ma-0"  
                                        
                                    style="background-color: white; height:40px;                                 
                                    border: 1px solid;border-radius: 0px;"
                                    label="YY"  
                                    maxlength = '2'                             
                                    v-model="additems.yy"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" 
                                    :error-messages="yyerr == '' ? '':yyerr"
                                    
                                    >
                            </v-text-field>
                        </v-col>

                        <v-col cols="6" lg="65" md="6" class="ma-0" dense  >
                          <v-progress-circular v-if="isContentLoading" :size="20" :width="20" color="#3c282f" indeterminate></v-progress-circular>

                            <v-autocomplete v-else label="DSTN" dense outlined  class="ma-0"                                  
                                     style="background-color: white; height:40px; ;
                                    border: 1px solid;border-radius: 0px;"
                                    :items="DestinationContent"  
                                    v-model="additems.dstn"
                                    :error-messages="dstnerr == '' ? '':dstnerr"   
                                    small      
                                    maxlength = '20' 
                                    clearable                   
                                 >
                                      <template #item="{ item}">                                     
                                         <span  >{{ item }}</span>                                         
                                        </template>
                            </v-autocomplete>
                        </v-col>
                     </v-row>                 
                     <v-row   class="mb-n4">
                        <v-col cols="12" lg="12" md="12" >
                          <v-progress-circular v-if="isContentLoading" :size="20" :width="20" color="#3c282f" indeterminate></v-progress-circular>
                            <v-autocomplete v-else label="Line" dense outlined                                    
                                     style="background-color: white; height:40px;;
                                    border: 1px solid;border-radius: 0px;"
                                    :items="LineList" 
                                    v-model="additems.lineid"
                                    :error-messages="lineiderr == '' ? '':lineiderr"      
                                    maxlength = '20'   
                                    clearable
                                 >
                                      <template v-slot:select="{ items }">
                                       <span>{{ items }}</span>
                                      </template>
                            </v-autocomplete>
                          </v-col>
                     </v-row> 
                     <v-row class="mt-3 " dense>
                            <v-col cols="12"  lg="12" md="12" class="text-center">
                               <v-btn 
                                  style="background-color: white;
                                  font-size: x-small;
                                   color:#5A0A0A;         
                                   width: 160px;                         
                                   border: 1px solid;border-radius: 0px;"
                                   @click="mExpExcValid(additems)" >{{ 'Export Summary' }}</v-btn>
                             </v-col>
                     </v-row>
                </v-card-text>
               
               
            </v-card>
        </v-dialog>   <!--Anchor  End dialog -->

       
   </div>
</template>

<script>
//NOTE start data
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
export default {
  components:{
    DatePicker
  },
  props:{
    notificationSystem:{type:Object,required:true}
  },
    data:() => ({
      TableHeader:['Request','ProductId','ConstructionCd/HouseCd','Product Date', 'Window Name', 'Exist', 'Unit Name', 'Qty', 'Line', 'Scheduled Date'],
        TableContent:[],
        Monitordialog: false,
        expsum:{WW:null,YY:null,DST:null,Line:null},
        Title:'Setting Schedule',
        Request:[],
        from:'',
        to:'',
        DestinationContent:[],
        filter:{dest:null,sched:null,nosched:false,line:null,req:null},
        searcherr:{from:null,to:null},
        isSchedLoading:false,
        LineList:[],
        ReqCode:[],
        ProductLineList:[],
        isPrinting: false,
        isExporting: false,
        Schedinput:null,
        Lineinput:null,
        Orderinput:null,
        disableinputctrl:false,
        newDate:null,
        pOrderclicked:null,
///export Variable
       adddialog: false,
        mDSTN:[],
        mLine:[], 
        additems:{
            ww: '',
            yy:'',
            dstn:'',
            lineid:''
        },
        isContentLoading:false,
        adderr:{},
        wwerr: '',
        yyerr: '',
        dstnerr: '',
        lineiderr: '',
        ToList:[],
        dateFormatted:null,
        menu1:false,
        isshowsearch:true,
        MasterData:[]
        
    }),
    created(){
      // this.mGetRequest()
      // this.mGetLine()
      // this.mGetProductLine()
      // this.mGetRequestCode()
      // this.mGetDestination()
      // this.mGetSummary()
      this.Request = [{Request: 'EX25-25A', Priority:1},{Request: 'EX25-25B', Priority:2},{Request: 'EX25-25C', Priority:3}, {Request: 'SA25-25A', Priority:4},{Request: 'SA25-25B', Priority:5},{Request: 'SA25-25C', Priority:6}]
      this.ReqCode = ['EX', 'SA']
      this.DestinationContent = ['A', 'B', 'C']
      this.LineList = ['Line1', 'Line2']
      this.MasterData = [
      {Priority: 1, REQUEST: "EX25-25A",ProductionId: 25120001, CDNO: "01XXXX-XX", EDA: "1", CAT_CD: "45", CAT_NAME: "BAYWINDOW", NameCode: 'NAME-X', PRODUCT_DATE: '2025-12-26', WINDOWTYPE: 'Window-X', Exist: 1, MAT_NAME: 'Unit-X', UNIT: 'Unit-X', cUNIT: 'Unit-alias-X', MAT_ELE_VALUE: 1, Line: 'Line1', ProductionScheduledDate: '2025-12-26', ProductionOrder: 1, RECEIVED_DATE: '2025-12-26', WallPanel: 'Z', SHIPMENT: 1},
      {Priority: 1, REQUEST: "EX25-25A",ProductionId: 25120002, CDNO: "02XXXX-XX", EDA: "1", CAT_CD: "45", CAT_NAME: "BAYWINDOW", NameCode: 'NAME-X', PRODUCT_DATE: '2025-12-26', WINDOWTYPE: 'Window-X', Exist: 1, MAT_NAME: 'Unit-X', UNIT: 'Unit-X', cUNIT: 'Unit-alias-X', MAT_ELE_VALUE: 1, Line: 'Line1', ProductionScheduledDate: '2025-12-26', ProductionOrder: 2, RECEIVED_DATE: '2025-12-26', WallPanel: 'Z', SHIPMENT: 1},
      {Priority: 3, REQUEST: "EX25-25C",ProductionId: 25120003, CDNO: "03XXXX-XX", EDA: "1", CAT_CD: "45", CAT_NAME: "BAYWINDOW", NameCode: 'NAME-X', PRODUCT_DATE: '2025-12-26', WINDOWTYPE: 'Window-X', Exist: 2, MAT_NAME: 'Unit-X', UNIT: 'Unit-X', cUNIT: 'Unit-alias-X', MAT_ELE_VALUE: 1, Line: 'Line2', ProductionScheduledDate: '2025-12-26', ProductionOrder: 1, RECEIVED_DATE: '2025-12-26', WallPanel: 'Z', SHIPMENT: 1},
      {Priority: 4, REQUEST: "SA25-25A",ProductionId: 25120004, CDNO: "04XXXX-XX", EDA: "1", CAT_CD: "45", CAT_NAME: "BAYWINDOW", NameCode: 'NAME-X', PRODUCT_DATE: '2025-12-26', WINDOWTYPE: 'Window-X', Exist: 1, MAT_NAME: 'Unit-X', UNIT: 'Unit-X', cUNIT: 'Unit-alias-X', MAT_ELE_VALUE: 1, Line: 'Line1', ProductionScheduledDate: '2025-12-26', ProductionOrder: 3, RECEIVED_DATE: '2025-12-26', WallPanel: 'Z', SHIPMENT: 1},
      {Priority: 5, REQUEST: "SA25-25B",ProductionId: 25120005, CDNO: "05XXXX-XX", EDA: "1", CAT_CD: "45", CAT_NAME: "BAYWINDOW", NameCode: 'NAME-X', PRODUCT_DATE: '2025-12-26', WINDOWTYPE: 'Window-X', Exist: 2, MAT_NAME: 'Unit-X', UNIT: 'Unit-X', cUNIT: 'Unit-alias-X', MAT_ELE_VALUE: 1, Line: 'Line2', ProductionScheduledDate: '2025-12-26', ProductionOrder: 2, RECEIVED_DATE: '2025-12-26', WallPanel: 'Z', SHIPMENT: 1}
      ]
      this.mTempTable('y')
    },
    mounted(){  
   
      //NOTE for scheduledate only watch
      this.$watch(() => this.filter.sched, (newValue) => {   
        
        this.dateFormatted = this.formatDate(newValue)
  
      });


        this.$watch(() => this.additems.ww, (newValue) => {            
          if(newValue){
              if(newValue >= '54'){    
                  this.wwerr = 'invalid  week'            
            }else if(newValue <= '52' && newValue != 0){
              this.wwerr = ''
            }else if(newValue == 0 || newValue =='00'){
              this.wwerr = 'invalid week'   
            }else{
              this.wwerr = 'invalid week'  
            }
          }else{
              this.wwerr = ''
          }         

        });  //end watch       
        
        this.$watch(() => this.additems.yy, (newValue) => {            
          if(newValue){
            
              if(newValue >= 10 && newValue <= 99) {
                  this.yyerr = ''     
              }else if(newValue.length == 1){  
                this.yyerr = 'invalid Year'
              }else{  
                this.yyerr = ''
              }
          }else{
              this.yyerr = ''
          }           

        });  //end watch 

        


   }, // End of Mounted
    methods:{
      mTempTable(item){
        let data = this.TableContent
        if(item != undefined)
          data = this.MasterData
        axios.post(`api/schedule`, {data:data,type:'tempsession'})
      },
      mAutoFill(e, field){
        let autofill = null
        if(field == 'from'){
          if(this.from == null || this.from == ''){
            autofill = this.Request.filter(rec => rec.Request.includes(e.target.value.toUpperCase()))
            if(autofill.length == 1)
              this.from = autofill[0].Priority
          }
           
        }
        else{
          if(this.to == null || this.to == ''){
            autofill = this.ToList.filter(rec => rec.Request.includes(e.target.value.toUpperCase()))
            if(autofill.length == 1)
              this.to = autofill[0].Priority 
          }
          
        }
        
      },  

      mCloseAdd(){
            this.adddialog = false
            this.additems.ww = ''
            this.additems.yy = ''
            this.additems.dstn = ''
            this.additems.lineid = ''  
            this.wwerr =''
                    this.yyerr =''
                    this.dstnerr =''
                    this.lineiderr =''          
      
        },
        mGetSummary(){
       this.isContentLoading = true
            axios.get(`api/export?ex=${'1'}`)
            .then(res => {   
                this.mDSTN = res.data.DSTN
                this.mLine = res.data.LINES
                this.isContentLoading = false;
            }).catch(err => {
                this.ErrorCode(err)
            })     
        },
        
        mExpExcValid(item){       
          // console.log(item, 'item');
           if(item.ww == '' && item.yy == '' && item.dstn == '' ){
                 this.wwerr ='Required';this.yyerr = 'Required'; this.dstnerr = 'Required'; 
           }else if(item.yy == '' && item.dstn == ''){
                 this.yyerr = 'Required'; this.dstnerr = 'Required';  this.wwerr = ''
           }else if(item.ww == '' && item.dstn == ''  ){
                this.wwerr ='Required'; this.dstnerr = 'Required';  this.yyerr = ''
           }else if(item.ww == '' && item.yy == ''  ){
                this.wwerr ='Required'; this.yyerr = 'Required';  this.dstnerr = ''
           }else if(item.ww == '' && item.yy == '' && (item.dstn == '' || item.dstn == null )){
                this.wwerr ='Required'; this.yyerr = 'Required'; this.dstnerr = 'Required'; this.lineiderr = ''
           }else if(item.ww == '' && item.yy == ''){
                this.wwerr ='Required';  this.yyerr = 'Required'; this.dstnerr = ''; this.lineiderr = '' 
           }else if(item.dstn == '' ){
                this.dstnerr = 'Required'; this.wwerr ='';  this.yyerr = '';
           }else if(item.ww== '' && item.dstn == ''){
                this.wwerr = 'Required'; this.dstnerr= 'Required'; this.lineiderr ='';  this.yyerr = '';
           }else if(item.yy== '' && item.dstn == ''){
                this.yyerr = 'Required'; this.dstnerr= 'Required'; this.wwerr = '';  this.lineiderr ='';  
           }else if(item.ww == '' ){
                this.yyerr = ''; this.dstnerr= ''; this.wwerr = 'Required';  
           }else if(item.yy == ''){
                this.yyerr = 'Required'; this.dstnerr= ''; this.wwerr = '';  
           }else if(item.yy == ''){
               this.yyerr = 'Required'; this.wwerr =''; this.dstnerr = ''; 
           }else if(item.dstn == '' || item.dstn == null){
                 this.dstnerr = 'Required'; this.wwerr =''; this.yyerr = ''; this.lineiderr = '' 
           }else if(item.ww == '' && (item.dstn == null || item.dstn == '')){
                 this.wwerr =  'Required';   this.dstnerr =  'Required'; this.yyerr = ''; 
           }else if(item.ww != '' && item.yy != '' && item.dstn != '' ){
                if(this.wwerr !== '' || this.yyerr !== '' || this.dstnerr !== '' ){
                    this.wwerr =''
                    this.yyerr =''
                    this.dstnerr =''
                    this.lineiderr =''
                }else{                   
                     this.dstnerr =''
                     this.lineiderr=''                  
                }
                this.mXportXcel(item)
           }  
           
        },
        mXportXcel(val){   
            
            if(val){
                window.open(`api/export?ex=${'2'}&&ww=${this.additems.ww}&&yy=${this.additems.yy}&&dstn=${this.additems.dstn}&&line=${this.additems.lineid}`);
            }            
            this.mCloseAdd();
        },

      mSearchSort(){
        if(this.TableContent.length != 0)
          this.TableContent.sort((a, b) => {
            if (a.ProductionOrder === undefined && b.ProductionOrder === undefined) return 0;
            if (a.ProductionOrder === undefined) return 1;
            if (b.ProductionOrder === undefined) return -1;
        return a.ProductionOrder - b.ProductionOrder})
      },
      // ANCHOR mSearchData 
      mSearch(){
        this.TableContent = []
        this.filter={dest:null,sched:null,nosched:false,line:null,req:null}
        this.searcherr = {from:null,to:null}
        this.isSchedLoading = true

        this.TableContent = this.MasterData.filter(rec => rec.Priority >= this.from && rec.Priority <= this.to)
          // axios.get(`api/schedule?from=${this.from}&to=${this.to}`)
          // .then(res => {
          //     this.TableContent = res.data

          //     //NOTE lagyan ng line if null, gamit ang ProductLineList
          //     let NewMats = []
          //     for(let x=0; x<this.TableContent.length; x++){
          //       if(this.TableContent[x].Line == null){
          //         let MyLine = this.ProductLineList.filter(rec => rec.Product == this.TableContent[x].MAT_NAME)

          //         if(MyLine.length != 0){
          //           // console.log(MyLine)
          //           this.TableContent[x].Line = MyLine[0].Line
          //         }
          //         else{
          //           let dupe = []
          //           if(NewMats.length != 0)
          //             dupe = NewMats.filter(rec => rec == this.TableContent[x].MAT_NAME)
                    
          //           if(dupe.length == 0){
          //             NewMats.push(this.TableContent[x].MAT_NAME)
          //             this.$toast.warning("Unregistered Product Line "+this.TableContent[x].MAT_NAME, 'NEW!', this.notificationSystem.options.error)
          //           }
                      
          //         }
                    
          //       }
          //     }




          //     this.mSearchSort()
          //     // this.TableHeader = Object.keys(res.data[0])

          // })
          // .catch((err) => {
          //     if(err.response == null){
          //         this.$store.dispatch('setStatusCode', 500)
          //         this.$router.push('/error/' + 500)
          //     }
          //     else if(err.response.status == 400){
          //       // console.log(err.response.data)
          //         if(err.response.data.from != null)
          //             this.searcherr.from = err.response.data.from[0]
          //         if(err.response.data.to != null)
          //           this.searcherr.to = err.response.data.to[0]
          //         // if(err.response.data != null && err.response.data.code == undefined  ){
          //         //     this.adderr = err.response.data
          //         // }   

          //     }
          //     else{
          //         this.$store.dispatch('setStatusCode', err.response.status)
          //         this.$router.push('/error/' + err.response.status)
          //     } 
          // })
          // .finally(() =>{
            this.mTempTable()
            setTimeout(() => {
              this.isSchedLoading = false
            }, 1000);
            
            
          // })
      },
      mGetRequest(){
          axios.get(`api/req?req=withyear`)
          .then(res => {
              this.Request = res.data
          })
          .catch(() => {
            this.mGetRequest()
          })
      },
      mGetRequestCode(){
        axios.get(`api/schedule/reqcode`)
          .then(res => {
              this.ReqCode = res.data
          })
          .catch(() => {
            this.mGetRequestCode()
          })
      },
      mGetLine(){
        axios.get(`api/schedule/line`)
          .then(res => {
              this.LineList = res.data
          })
          .catch(() => {
            this.mGetLine()
          })
      },

      mGetProductLine(){
        axios.get(`api/schedule/productline`)
          .then(res => {
              this.ProductLineList = res.data
              // console.log(this.ProductLineList)
          })
          .catch(() => {
            this.mGetProductLine()
          })
      },
   
      mexportmary(){
        //GP
        // console.log('sir GP')
      },
      mPrinting(val){
        let count = this.cSched.length
        let data = this.cSched;
        if(count != 0){
          if(val == 'export')
            this.mExport()
          else if(this.filter.line){
            if(val == 'print')
              this.mPrint(data, count)
            else
              this.mTile(data, count)

          }
          else{
            this.$toast.error('Select a Line before Printing!', 'Error', this.notificationSystem.options.error)
          }
        }
        else{
          this.$toast.error('No data!', 'Error', this.notificationSystem.options.error)
        }
      },
      mPrint(data, count){
        if(this.filter.line == 'Demado'){
          this.isPrinting = true
          // axios.post(`${this.$url}/api/schedule`, {data:data,count:count,type:'mis'}, {responseType: 'blob'})
          // .then(res => {
          //   const url = window.URL.createObjectURL(new Blob([res.data], {type: 'application/pdf'}));
          //   window.open(url, '_blank');
          // })
          axios.get(`api/schedule?type=mis&line=${this.filter.line}`)
          .then(res => {
            window.open(`api/schedule?type=mis2&line=${this.filter.line}`, '_blank');
          })
          .catch((err) => {
              if(err.response == null){
                  this.$store.dispatch('setStatusCode', 500)
                  this.$router.push('/error/' + 500)
              }
              else if(err.response.status == 400){
                this.$toast.error('Material Issuance Slip - No Issuance Request Data Found!', 'Error', this.notificationSystem.options.error)

              }
              else{
                  this.$store.dispatch('setStatusCode', err.response.status)
                  this.$router.push('/error/' + err.response.status)
              } 
          })
          .finally(()=>{
            this.mCutandSetPrint(data, count)
            this.isPrinting = false
          })
        }
        else
          this.mCutandSetPrint(data, count)
           

      },
      mCutandSetPrint(data, count){
        // Unfortunately, when opening Blob URLs directly in a new tab, there is no way to enforce the filename used by the browser's PDF viewer on download, and it will fallback to the blob identifier naming.
        //last option if needed, separate download and viewing. Custom download button and iframe for viewing
      //in this case i use session
        window.open(`api/schedule?type=setsched&line=${this.filter.line}`, '_blank');
        window.open(`api/schedule?type=cutsched&line=${this.filter.line}`, '_blank');
        // axios.post(`api/schedule`, {data:data,count:count,type:'setsched'}, {responseType: 'blob'})
        // .then(res => {
        //   const url = window.URL.createObjectURL(new Blob([res.data], {type: 'application/pdf'}));
        //   window.open(url, '_blank');
        // })
        // axios.post(`${this.$url}/api/schedule`, {data:data,count:count,type:'cutsched'}, {responseType: 'blob'})
        // .then(res => {
        //   const url = window.URL.createObjectURL(new Blob([res.data], {type: 'application/pdf'}));
        //   window.open(url, '_blank');
        // })
      },
      mExport(){
        this.isExporting = true
        let data = Object.assign([], this.cSched)
        data = data.filter(rec => rec.ProductionId != undefined)
        data = data.sort((a, b) => a.Line.localeCompare(b.Line)    
        )
        

        if(data.length != 0){
          axios.post(`api/schedule`, {data:data,type:'export'}, {responseType: 'blob'})
          .then(res => {
            const url = window.URL.createObjectURL(new Blob([res.data]));
            // window.open(url, '_blank');
            const link = document.createElement("a");
              link.href = url
              link.setAttribute("download", 'ScheduledProducts '+this.cSched[0].ProductionScheduledDate.replace(/-/g, "")+'.xls')
              document.body.appendChild(link)
              link.click();
              link.remove();
                this.uploading = false
                this.filename = ''
          })
          .catch((err) => {
                if(err.response == null){
                    this.$store.dispatch('setStatusCode', 500)
                    this.$router.push('/error/' + 500)
                }
              
                else{
                    this.$store.dispatch('setStatusCode', err.response.status)
                    this.$router.push('/error/' + err.response.status)
                } 
            })
          .finally(()=>{
            this.isExporting = false;
          })
        }
        else{
          this.isExporting = false;
          this.$toast.error('No data!', 'Error', this.notificationSystem.options.error)
        }
        
      },
      mTile(data, count){
            window.open(`api/schedule?type=tilechecklist&line=${this.filter.line}`, '_blank');
            // axios.post(`${this.$url}/api/schedule`, {data:data,count:count,type:'tilechecklist'}, {responseType: 'blob'})
            // .then(res => {
            //   const url = window.URL.createObjectURL(new Blob([res.data], {type: 'application/pdf'}));
            //   window.open(url, '_blank');
            // })
            // .catch((err) => {
            //   if(err.response == null){
            //       this.$store.dispatch('setStatusCode', 500)
            //       this.$router.push('/error/' + 500)
            //   }
            
            //   else{
            //       this.$store.dispatch('setStatusCode', err.response.status)
            //       this.$router.push('/error/' + err.response.status)
            //   } 
            // })
        
      },
      mCloseMonitor(){
        this.Monitordialog = false
        this.expsum = {WW:null,YY:null,DST:null,Line:null}
      },

         // ANCHOR mGet Destination
         mGetDestination(){
            axios.get(`api/req?dest=1`)
            .then(res => {
                this.DestinationContent = res.data
            })
            .catch(err =>{
                let errorval = 500;
                if(err.response != null){
                    errorval = err.response.status
                }
                this.$store.dispatch('setStatusCode', errorval)
                this.$router.push('/error/' + errorval)
            })
        },

        // ANCHOR mEdit Schedule 
        mEditSched(val){
          
          if(val == undefined){
            // this.disableinputctrl = true
            if(this.cSched.length != 0 && this.newDate != null){
              // axios.post(`${this.$url}/api/schedule`, {data:this.cSched,newDate:this.newDate,type:'editsched'})
              // .then(res => {
                let data = this.cSched
                for(let x=0;x<data.length;x++){
                  if(data[x].ProductionId != undefined)
                    data[x].ProductionScheduledDate = this.newDate
                }
                this.$toast.success("Product's Schedule Date has been updated!", 'OK', this.notificationSystem.options.success)
              // })
              // .finally(()=>{  
              //   this.disableinputctrl = false
                this.newDate = null
              // })
            }
            else if(this.newDate == null){
              this.$toast.error('Date input not set!', 'Error', this.notificationSystem.options.error)
              // this.disableinputctrl = false
            }
            else{
              this.$toast.error('Table Data is empty!', 'Error', this.notificationSystem.options.error)
              // this.disableinputctrl = false
            }
          }
          else{
            // if(val.ProductionScheduledDate != e){
              // this.disableinputctrl = true
              let sched = this.filter.sched
              if(val.ProductionId != null){
                // val.ProductionScheduledDate = e
                
                // axios.post(`${this.$url}/api/schedule`, {data:val,type:'editsched'})
                // .then(res => {
                  this.filter.sched = null
                  this.$toast.success('ProductId: '+(val.ProductionId)+' - Schedule Date has been updated!', 'OK', this.notificationSystem.options.success)
                // })
                // .finally(()=>{
                  this.filter.sched = sched
                //   this.disableinputctrl = false
                // })
              }
              // else{
                //NOTE get latest productorder
                // const ThisLine = this.TableContent.filter(rec => rec.Line == val.Line);

                // const maxOrder = ThisLine.reduce((max, content) => {
                //   // Compare the current maximum value (max) with the current object's Order
                //   const currentOrder = content.ProductionOrder ?? 0;
                //   return Math.max(max, currentOrder);
                // }, -Infinity);
                

            
                // val.ProductionOrder = maxOrder+1
                
                  // NOTE set new productid 
              //   axios.post(`${this.$url}/api/schedule`, {data:val,type:'addproductid'})
              //   .then(res => {
              //     if(res.data){
              //       this.filter.sched = null
              //       this.$toast.success('ProductId: '+(res.data)+' - has been set!', 'OK', this.notificationSystem.options.success)
              //       val.ProductionId = res.data
              //       this.mSearchSort()
              //     }
              //     else{
              //       val.ProductionOrder = null
              //       this.filter.sched = null
              //       this.$toast.success('Failed to make productionid', 'OK', this.notificationSystem.options.success)
              //     }
                  
              //   })
              //   .finally(()=>{
              //     this.filter.sched = sched
              //     this.disableinputctrl = false
              //   })
              // }
             
            // }
   
          }
          this.mTempTable()
       
        },

        // ANCHOR mEdit Line 
        mEditLine(val){
          let line = this.filter.line
          // if(val.ProductionId != null){
          //   this.disableinputctrl = true
          //   axios.post(`${this.$url}/api/schedule`, {data:val,type:'editline'})
          //   .then(res => {
          //     this.filter.line = null
              this.$toast.success('ProductId: '+(val.ProductionId)+' - Line has been updated!', 'OK', this.notificationSystem.options.success)
            // })
            // .finally(()=>{
              this.filter.line = line
          //     this.disableinputctrl = false
          //   })
          // }
          // else{
          //   console.log(val)
          //   this.$toast.success('Line Set', 'OK', this.notificationSystem.options.success)
          // }
          this.mTempTable()
        
        },

          // ANCHOR mEdit Order
        mEditOrder(val,e){
          this.pOrderclicked = null
          if(e != '' && e > 0){
            e = Number(e)
            val.ProductionOrder = e

            // if(val.ProductionId != null){
            //   this.disableinputctrl = true
            //   axios.post(`${this.$url}/api/schedule`, {data:val,type:'editorder'})
            //   .then(res => {
                this.$toast.success('ProductId: '+(val.ProductionId)+' - Product Order has been updated!', 'OK', this.notificationSystem.options.success)
                this.mSearchSort()
            //   })
            //   .finally(()=>{
            //     this.disableinputctrl = false
            //   })
            // }
            // else{
            //   this.$toast.success('ProductionOrder Set', 'OK', this.notificationSystem.options.success)
            // }
            this.mTempTable()
          }
          else{
            this.filter.nosched = !this.filter.nosched
            setTimeout(() => {
              this.filter.nosched = !this.filter.nosched
            }, 1);
          }
          
          

        },
       


        //NOTE for scheduledate only method
        formatDate (date) {
          if (!date) return null

          const [year, month, day] = date.split('-')
          return `${year}/${month}/${day}`
        },
        parseDate (date) {
          if (!date) return null

          const [year,month, day] = date.split('/')
          return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        },
       

    },
    computed:{
      // cFrom(){
      //   if(this.Request)
      //     return this.Request.filter(rec => rec.Request.includes('AW'))
      //   else
      //     return []
      // },
      //ANCHOR filter function
      cSched(){
        let data = this.TableContent
        //no schedule
        if(this.filter.nosched)
          data = data.filter(rec => rec.ProductionScheduledDate == "" || rec.ProductionScheduledDate == null)
        //destination
        if(this.filter.dest)
          data = data.filter(rec => rec.REQUEST.slice(7,9) == this.filter.dest)
        //scheduledate
        if(this.filter.sched){
          data = data.filter(rec => rec.ProductionScheduledDate == this.filter.sched)
        }
        if(this.filter.line){
          data = data.filter(rec => rec.Line == this.filter.line)
        }
        if(this.filter.req){
          data = data.filter(rec => rec.REQUEST.slice(0,2) == this.filter.req)
        }
        //line

        //requestcode
      
        
          return data
      },

      //NOTE Fill To if From already filled
      // cTo(){
      //   if(this.from){
      //     let key = this.Request.findIndex(rec => rec.Priority == this.from)
      //     this.to = ''
      //     let getnext = this.Request.slice(key,this.Request.length)
      //     console.log(getnext.slice(0,2000))
      //     return getnext.slice(0,2000)
          // NOTE it should be this.Request.length but limited to 1000 because of query only accept 2100 parameters
      //   }
          
      //   else
      //     return []
      // }
    },
    watch:{
      from(curr,prev){
        if(curr){
          if(curr != prev){
            let key = this.Request.findIndex(rec => rec.Priority == this.from)
            this.to = ''
            let getnext = this.Request.slice(key,this.Request.length)
            // console.log(getnext.slice(0,2000))
            this.ToList = getnext.slice(0,2000)
          // NOTE it should be this.Request.length but limited to 1000 because of query only accept 2100 parameters
          }
          // console.log(curr,prev)
        }
        else
          this.ToList = []
      
      },

     

      // newDate(val){
      //   if(val)
      //     this.newDate = this.newDate.replace(/-/g, '/')
      // }
    }
}
</script>

<style scoped>
/* NOTE Search grid  */
.search-grid-container {
  display: grid;
  grid-template-areas:
    'title from to search';
  gap: 5px;
  margin-bottom: -10px;
}

.fromgrid{
    grid-area: from;
    text-align: center;
   
}

.togrid{
    grid-area: to;
  text-align: center;
}

.searchgrid{
    grid-area: search;
  text-align: center;
}

.titlegrid{
    grid-area: title;
  text-align: center;
  color:"#5a0a0a";
  font-size: 20px;
  padding-top: 7px;
}

/* NOTE filter grid  */
.filter-grid-container {
  display: grid;
  grid-template-areas:
    'title line req dest schedule notsched clear';
  gap: 10px;
  margin-bottom: -10px;
  
}

.filter-grid-container-sm {
  display: grid;
  grid-template-areas:
    'title line req'
    'blank dest schedule'
    'blank notsched clear';
  gap: 10px;
  margin-bottom: -10px;
  
}

.linegrid{
    grid-area: line;
    text-align: center;
}

.reqgrid{
    grid-area: req;
  text-align: center;
}

.schedulegrid{
    grid-area: schedule;
  text-align: center;
}

.destgrid{
    grid-area: dest;
  text-align: center;
}

.notschedgrid{
    grid-area: notsched;
  text-align: center;
  margin-top: -10px;
}

.cleargrid{
    grid-area: clear;
  text-align: center;
}

/* NOTE function grid  */
.function-grid-container {
  display: grid;
  grid-template-areas:
    'print export tile';
  gap: 10px;
  margin-bottom: -10px;
  width: 40%;
  
}
.function-grid-container-xs {
  display: grid;
  grid-template-areas:
    'print print' 'export export' 'tile tile' 'setsched save';
  gap: 10px;
  margin-bottom: -10px;
  
}

.printgrid{
    grid-area: print;
  text-align: center;
}

.exportgrid{
    grid-area: export;
    text-align: center;
}

.tilegrid{
    grid-area: tile;
  text-align: center;
}

.setschedgrid{
    grid-area: setsched;
  text-align: right;
}

.savegrid{
    grid-area: save;
  text-align: left;
}

.absoluteright{
  position: absolute; 
  top: 0; 
  right: 0; 
  
}

th:not(:nth-child(3)) {
  height: 100% !important;
}

.BLU{
  background-color: #dae8fc;
}

.GRN{
  background-color: #d5e8d4;
}

.YLW{
  background-color: 	#ffecb3;
}
.promptempty{
    margin-top: 20px;
    color: gray;
    font-size: 50px;
}

.no-underline >>> .v-input__slot::before {
  border-style: none !important;
}

.datepicker-noborder >>> input {
  border: none;
  box-shadow: none; /* Optional: Remove any box-shadow that might create a border-like effect */
  outline: none; /* Optional: Remove outline on focus */
}

.Beigecover{
    background-color:#e9c9aa;
}
.marbeige{
    background-color: #5a0a0a !important;
    color: #e9c9aa !important;
}

.Beigetext{
    color:#e9c9aa;
}

.Marooncover{
    background-color:#5a0a0a;
}

.Maroontext{
    color:#5a0a0a;
}

.Titlesize{
    font-size: 25px;
}

.Subtitlesize{
    font-size: 20px;
}

.buttonsmcaps{
    text-transform: none;
}

.v-data-table tbody tr td {
    border: 1px solid;
    height: 100% !important;
    white-space: nowrap;
  }

.square{
    border: 1px solid;
}
</style>