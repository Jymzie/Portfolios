<template>
<v-card>
    <v-card-title>BarChart User List
        <v-spacer />

        <v-tooltip left>
            <template v-slot:activator="{ on, attrs }">
                <v-btn v-on="on" v-bind="attrs" @click="AddDialog = !AddDialog" class="green white--text">
                    <v-icon>mdi-account-plus</v-icon>
                </v-btn>
            </template>
            <span>Add Account</span>
        </v-tooltip>

    </v-card-title>

    <v-card-text class="mb-n12">
        <v-row>
            <v-col cols="7" lg="4" sm="7">
                <v-text-field dense outlined v-model="search" label="Search Employee"></v-text-field>
                <v-card-subtitle>(click the table row to show the list of their access)</v-card-subtitle>
            </v-col>
            <v-col cols="5" lg="8" sm="5">

            </v-col>
        </v-row>

    </v-card-text>
    <v-card-text>
        <v-simple-table fixed-header height="500">
            <thead>
                <tr>
                    <th class="HeaderDesign" v-for="(header,i) in BarChartHeader" :key="i">
                        {{header}}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item,i) in SearchData" :key="i">
                    <td class="TableDesign" @click="mAccessList(item.EmployeeID)">{{item.EmployeeID}}</td>
                    <td class="TableDesign" @click="mAccessList(item.EmployeeID)">{{item.EmployeeName}}</td>
                    <td class="TableDesign" @click="mAccessList(item.EmployeeID)">{{item.SectionID}}</td>
                    <td class="TableDesign" @click="mAccessList(item.EmployeeID)">{{item.DivisionID}}</td>
                    <td class="TableDesign" @click="mAccessList(item.EmployeeID)">{{item.UserName}}</td>
                    <td class="TableDesign" @click="mAccessList(item.EmployeeID)">{{item.IPAddress}}</td>
                    <td class="TableDesign">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn fab x-small v-on="on" v-bind="attrs" @click="mOpenDialog(item.EmployeeID)" class="green white--text mr-4">
                                    <v-icon>mdi-table-plus</v-icon>
                                </v-btn>
                            </template>
                            <span>Add Access</span>
                        </v-tooltip>
                    </td>
                </tr>

            </tbody>
        </v-simple-table>
    </v-card-text>
    <v-dialog v-model="AddDialog" width="70%" persistent>
        <v-card>
            <v-card-title class="blue white--text mb-4">Create Account
                <v-spacer />
                <v-btn fab x-small color="black" @click="mCloseDialog">
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field dense outlined label="Employee ID (Press enter to verify)" @keyup.enter="mIsIDExisting(AddValue.EmployeeID)" v-model="AddValue.EmployeeID" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength='7' :error-messages="errormessage"></v-text-field>
                <v-text-field dense outlined label="Employee Name" v-model="AddValue.EmployeeName" v-show="isExisting == true"></v-text-field>
                <v-select dense outlined v-model="AddValue.SectionID" item-text="SectionName" item-value="SectionID" label="Section ID" :items="SectionData" v-show="isExisting == true">
                </v-select>
                <v-text-field dense outlined label="Division ID" v-model="AddValue.DivisionID" v-show="isExisting == true"></v-text-field>
                <v-text-field dense outlined label="Username" v-model="AddValue.UserName" v-show="isExisting == true"></v-text-field>
                <v-text-field dense outlined label="Password" v-model="AddValue.EmployeePassword" v-show="isExisting == true"></v-text-field>
                <v-text-field dense outlined label="IP Address" v-model="AddValue.IPAddress" v-show="isExisting == true"></v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="isDisabled" @click="mInsertAcc">Add</v-btn>
            </v-card-actions>

        </v-card>
    </v-dialog>
    <v-dialog v-model="ChartDialog" width="80%" persistent>
        <v-card>
            <v-card-title class="blue white--text mb-4">{{isEdit ? 'Edit' : 'Add'}} Section Access
                <v-spacer />
                <v-btn fab x-small color="black" @click="mCloseDialog">
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-row>
                    <v-col cols="8">
                        <v-select dense outlined readonly v-model="AddValue.EmployeeID" label="Employee" :items="BarChartTable" item-text="EmployeeName" item-value="EmployeeID">
                        </v-select>
                    </v-col>
                    <v-col cols="4">
                        <v-combobox v-model="AddValue.EmployeeID" readonly item-text="EmployeeID" item-value="EmployeeID" label="ID" dense outlined :return-object="false" :items="BarChartTable">
                        </v-combobox>
                    </v-col>
                </v-row>
                <v-combobox :multiple="!isEdit" v-model="SectionID" item-text="SectionName" item-value="SectionName" label="Section" dense outlined :return-object="false" :items="cSection">
                </v-combobox>

            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="isDisabled2" @click="mInsertChart">{{isEdit ? 'Edit' : 'Add'}}</v-btn>
            </v-card-actions>

        </v-card>
    </v-dialog>
    <v-dialog v-model="AccessDialog" width="80%" persistent>
        <v-card>
            <v-card-title class="blue white--text mb-4">Accessed Sections
                <v-spacer />
                <v-btn fab x-small color="black" @click="AccessDialog=!AccessDialog">
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field dense outlined v-model="searchrq" label="Search Request Name"></v-text-field>
                <v-simple-table fixed-header height="350">

                    <tbody>
                        <tr v-for="(item,i) in SearchAccess" :key="i">

                            <td>{{item.SectionID}}</td>
                            <td>{{item.SectionName}}</td>
                            <td>
                                <v-tooltip right>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn fab x-small v-on="on" v-bind="attrs" color='yellow' @click="mEditAccess(item.SectionID)">
                                            <v-icon color="#FFFFFF">mdi-table-edit</v-icon>
                                        </v-btn>
                                    </template>
                                    <span class="spancolor">Edit Access</span>
                                </v-tooltip>
                            </td>

                        </tr>
                        <h1 v-show="AccessList[0] == null" style="text-align:center" class="my-12">
                            No Access Yet
                        </h1>
                    </tbody>
                </v-simple-table>
            </v-card-text>

        </v-card>
    </v-dialog>
    <v-footer color="titlecolor" dark fixed>
        <div>
            <span>This system (Access Manager) acts as the Account Creator and User Access Permission of the Barchart System and Shukka System.</span>
            <br>
            <span class="red--text">Note: This program is statistically modified!</span>
        </div>
    </v-footer>
</v-card>
</template>

<script>
export default {
    data() {
        return {
            errormessage: '',
            BarChartHeader: ['Employee ID', 'EmployeeName', 'Section ID', 'Division ID', 'UserName', 'IP Address', 'Actions'],
            BarChartTable: [{
                DivisionID: "TestDivision",
                EmployeeID: "000001 ",
                EmployeeName: "Test User",
                EmployeePassword: "123",

                IPAddress: "192.168.112",
                SectionID: "TestSection",

                UserLevel: "1",
                UserName: "test"
            }, {
                DivisionID: "HTI Panel",
                EmployeeID: "45036",
                EmployeeName: "Jimwell",
                EmployeePassword: "123",

                IPAddress: "192.168.112",
                SectionID: "SSD",

                UserLevel: "1",
                UserName: "Jymz"
            }],
            ChartData: [{
                    ChartSectionID: 1,
                    EmployeeID: "000001"
                },
                {
                    ChartSectionID: 0,
                    EmployeeID: "45036"
                }
            ],
            isExisting: false,
            search: '',
            searchrq: '',
            SectionData: [{
                SectionName: "SSD",
                SectionID: 0
            }, {
                SectionName: "HRD",
                SectionID: 1
            }, {
                SectionName: "HTI",
                SectionID: 2
            }, {
                SectionName: "Wukong",
                SectionID: 3
            }, ],
            AddDialog: false,
            ChartDialog: false,
            AccessDialog: false,
            AccessList: {},
            SectionID: '',
            isEdit: false,
            AddValue: {
                EmployeeID: '',
                EmployeeName: '',
                ChartSectionID: '',
                DivisionID: '',
                UserName: '',
                UserLevel: 2,
                EmployeePassword: '',
                IPAddress: ''
            },
        }

    },

    watch: {
        SectionID(val) {
            if (this.isEdit) {
                let x = this.SectionData.filter(rec => val == rec.SectionName)
                    .map(req => {
                        return req.SectionID
                    })
                this.AddValue.ChartSectionID = x[0]
            } else
                this.AddValue.ChartSectionID = this.SectionData.filter(rec => val.includes(rec.SectionName))
                .map(req => {
                    return req.SectionID
                })
        }
    },
    computed: {
        cSection() {
            if (this.AddValue.EmployeeID) {
                this.AddValue.SectionID = ''
                let data = this.ChartData.filter(rec => this.AddValue.EmployeeID.includes(rec.EmployeeID))
                    .map(req => {
                        return req.ChartSectionID
                    })

                return this.SectionData.filter(rec => !data.includes(rec.SectionID))
            } else
                return this.SectionData
        },
        SearchAccess() {
            if (this.searchrq)
                return this.AccessList.filter(rec => rec.SectionName.toLowerCase().includes(this.searchrq.toLowerCase()))
            else
                return this.AccessList
        },
        SearchData() {
            if (this.search)
                return this.BarChartTable.filter(rec => rec.EmployeeID.includes(this.search) || rec.EmployeeName.toLowerCase().includes(this.search.toLowerCase()))
            else
                return this.BarChartTable
        },
        isDisabled() {
            return this.AddValue.EmployeeID == '' || this.AddValue.EmployeeName == '' || this.AddValue.SectionID == '' || this.AddValue.DivisionID == '' || this.AddValue.UserName == '' || this.AddValue.EmployeePassword == '' || this.AddValue.IPAddress == ''
        },
        isDisabled2() {
            return this.AddValue.EmployeeID == '' || this.AddValue.ChartSectionID == ''
        },
    },
    methods: {
        mAccessList(item) {
            this.AccessDialog = true
            this.AddValue.EmployeeID = item
            let data = this.ChartData.filter(rec => item.includes(rec.EmployeeID))
                .map(req => {
                    return req.ChartSectionID
                })
            this.AccessList = this.SectionData.filter(rec => data.includes(rec.SectionID))

        },
        mOpenDialog(item) {
            this.ChartDialog = true
            this.AddValue.EmployeeID = item
        },
        mCloseDialog() {
            this.errormessage = ''
            this.AddDialog = false
            this.ChartDialog = false
            this.isExisting = false
            this.AccessDialog = false
            this.searchrq = ''
            this.SectionID = ''
            if (this.isEdit == false)
                this.AddValue = {
                    EmployeeID: '',
                    EmployeeName: '',
                    ChartSectionID: '',
                    DivisionID: '',
                    UserName: '',
                    UserLevel: 2
                }
            this.isEdit = false
        },
        mGetBarChart() {
            axios.get(`${this.$url}/api/employeeslogin`)
                .then(res => {
                    this.BarChartTable = res.data
                }).catch(({
                    response
                }) => {
                    this.$store.dispatch('setStatusCode', response.status)
                    this.$router.push('/error/' + response.status)
                })
        },
        mGetChart() {
            axios.get(`${this.$url}/api/chartsection`)
                .then(res => {
                    this.ChartData = res.data
                }).catch(({
                    response
                }) => {
                    this.$store.dispatch('setStatusCode', response.status)
                    this.$router.push('/error/' + response.status)
                })
        },
        mGetSection() {
            axios.get(`${this.$url}/api/section`)
                .then(res => {
                    this.SectionData = res.data
                }).catch(({
                    response
                }) => {
                    this.$store.dispatch('setStatusCode', response.status)
                    this.$router.push('/error/' + response.status)
                })
        },
        mIsIDExisting(item) {

            let find = this.BarChartTable.filter(rec => rec.EmployeeID == item)
            if (find.length === 0) {
                this.errormessage = ''
                this.isExisting = true
            } else {
                this.errormessage = 'Account Already Existed'
                this.isExisting = false
            }
            // if(this.AddValue.EmployeeID != ''){
            //   axios.get(`${this.$url}/api/employeeslogin/${item}`)
            // .then(res =>{
            //   console.log(res);
            //   if(res.data != 0){
            //     alert('Account Exist')
            //     this.isExisting = false
            //   }
            //   else{
            //     alert('Account Available')
            //     this.isExisting = true
            //   }

            // }).catch(({response}) => {
            //           this.$store.dispatch('setStatusCode', response.status)
            //           this.$router.push('/error/' + response.status)
            //       })
            // }

        },
        mEditAccess(item) {
            this.isEdit = true
            this.ChartDialog = true
            this.AddValue.ReplaceSection = item
        },
        mInsertChart() {
            if (this.isEdit) {
                for (let x = 0; x < this.ChartData.length; x++) {
                    if (this.ChartData[x].ChartSectionID == this.AddValue.ReplaceSection &&
                        this.ChartData[x].EmployeeID == this.AddValue.EmployeeID) {
                        this.ChartData[x] = {
                            EmployeeID: this.AddValue.EmployeeID,
                            ChartSectionID: this.AddValue.ChartSectionID
                        }
                        break;
                    }

                }

                // axios.patch(`${this.$url}/api/chartsection/edit`,this.AddValue)
                // .then(res =>{
                //   alert(res.data)
                // }).catch(({response}) => {
                //           this.$store.dispatch('setStatusCode', response.status)
                //           this.$router.push('/error/' + response.status)
                //       })
            } else {
                for (let x = 0; x < this.AddValue.ChartSectionID.length; x++) {
                    this.ChartData[this.ChartData.length] = {
                        EmployeeID: this.AddValue.EmployeeID,
                        ChartSectionID: this.AddValue.ChartSectionID[x]
                    }
                }

                alert('Success')
                // axios.post(`${this.$url}/api/chartsection`,this.AddValue)
                // .then(res =>{
                //   alert(res.data)
                // }).catch(({response}) => {
                //           this.$store.dispatch('setStatusCode', response.status)
                //           this.$router.push('/error/' + response.status)
                //       })
            }
            // this.mGetChart()
            this.mCloseDialog()

        },
        mInsertAcc() {
            this.BarChartTable[this.BarChartTable.length] = this.AddValue
            alert('Success!')
            this.AddDialog = false
            // axios.post(`${this.$url}/api/employeeslogin`,this.AddValue)
            // .then(res =>{
            //   alert('Success!')
            // }).catch(({response}) => {
            //           this.$store.dispatch('setStatusCode', response.status)
            //           this.$router.push('/error/' + response.status)
            //       })

        }
    }
}
</script>

<style>
.TableDesign {
    border: 1px solid black !important;
    border-collapse: collapse;
    text-align: center;
}

.HeaderDesign {
    color: white !important;
    background-color: #2196F3 !important;
    text-align: center !important;
}

.v-list {
    background-color: rgba(255, 255, 255, 1) !important;
}
</style>
