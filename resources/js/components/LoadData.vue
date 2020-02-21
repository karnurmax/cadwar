<template>
<div class="container">
    <div class="row">
        <div class="page-title">
            <p>
                <h2>Базы данных</h2>
            </p>
        </div>
        <div class="col-12">
            <b-list-group>
                <b-list-group-item>
                    <b-button @click="$refs.csvLoadInput.click()">csv</b-button>
                </b-list-group-item>
                
            </b-list-group>
        </div>
    </div>
    <div style="display:none;">
        <input style="display:none;" type="file" ref="csvLoadInput" accept=".csv" @change="uploadCSV"/>
    </div>
</div>
</template>

<script>
import loadDataService from '../services/loadData'
export default {
    data() {
        return {
            fileAccept:'.*'
        }
    },
    methods: {
        uploadCSV(e){
            const self = this;
            window['test'] = e;
            if(!e.target.files.length)
                return;
            const file = e.target.files;
            loadDataService.loadCSV(file).then(res=>{
                window.console.log(res);
                window.alert("База загружена успешно");
            }).catch(err=>{
                window.console.log(err);
                window.alert("Произошла ошибка");
            });
            return;
            // const reader = new FileReader();
            // reader.readAsText(file);
            // reader.onload = function(event) {
            //     var csv = event.target.result;
            //     var rows = csv.split('\n');
            //     for (var i = 1; i < rows.length; i++) {
            //         //split by separator (,) and get the columns
            //         let cols = self.getValuesArray(rows[i]);
            //     }
            // }
        },
        getValuesArray(row){
            const vals = [];
            while(row.length){
                if(row[0]==='"'){
                    let idx = row.indexOf('",');
                    if(idx<0){
                        vals.push(row);
                        return vals;
                    }
                    vals.push(row.substring(1,idx));
                    row = row.substring(idx+2);
                }else{
                    let idx = row.indexOf(',');
                    if(idx<0){
                        vals.push(row);
                        return vals;
                    }
                    vals.push(row.substring(0,idx));
                    row = row.substring(idx+1);
                }
            }
            return vals;
        }
    },
}
</script>
