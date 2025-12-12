<template>
   <v-card >
        <v-card-text>
            <v-simple-table fixed-header :height="$vuetify.breakpoint.height < 600 ? 350+'px':$vuetify.breakpoint.height-450+'px'" class="BlackBorder">
                <thead dense>
                    <tr>
                        <th style="background-color:#290000; color:#D4B79B; font-size: 1.2vw;" class="TableBorder text-center" v-for="(header,i) in Header" :key="i">{{header}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item,i) in AccessoriesTableData" :key="i" :style="item.CheckedFlg== 3 ? 'background-color: #ffdcd4; color: red' : ''">
                        <td class="TableDesign"><input :disabled='item.CheckedFlg == 3' style="height: 2vw; width: 2vw;" type="checkbox"  @click="mCheckFlg(item)"  :checked="item.CheckedFlg == 1 ? true: false" /></td>
                        <td class="TableDesign" style="text-align: right">{{item.Qty}}</td>
                        <td class="TableDesign" style="text-align: left">{{item.Unit}}</td>
                        <td class="TableDesign">{{item.ItemName}}</td>
                        <td class="TableDesign">
                            <v-tooltip right v-if="item.CheckedFlg == 3" >
                                <template v-slot:activator="{ on, attrs }">
                                        <v-icon  v-on="on" v-bind="attrs" color="red">mdi-exclamation-thick</v-icon>
                                </template>
                                <span class="spancolor" v-for="(error,k) in ForConfirmationData" :key="k">{{item.CtrlID == item.CtrlID ? error.Remarks : ""}}</span>
                            </v-tooltip>
                            <div class="actionButtons" v-else>
                                
                                <v-tooltip right >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn x-small v-on="on" v-bind="attrs" color="#FA6800" class="py-4" :disabled="item.CheckedFlg == 1"  @click="mOpenConfirmation(item)">
                                            <v-icon color="#FFFFFF">mdi-dots-horizontal</v-icon>
                                        </v-btn>
                                    </template>
                                    <span class="spancolor">Confirmation</span>
                                </v-tooltip>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>
        </v-card-text>
    </v-card>
</template>

<script>

export default {
    props:{
        AccessoriesTableData:{
            type: Array
        },
        ForConfirmationData:{
            type: Array
        },
        mOpenConfirmation:{
            type: Function
        },
        mCheckFlg:{
            type: Function
        },
        mRemark:{
            type: Function
        },
      
    },
    data() {
        return {
            val: '',
            oldVal:'',
            checkFlag: false,
            Header: ['STATUS', 'QTY', 'UNIT', 'ITEM NAME', ''],
            index: '',
        }
    },
    methods: {
 
    }
}
</script>

<style>
 
</style>
