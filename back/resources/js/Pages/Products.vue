<template>
   <app-layout>
      <!--      <template #header>-->
      <!--         <h2 class="font-semibold text-xl text-gray-800 leading-tight">-->
      <!--            IN PROGRESS-->
      <!--         </h2>-->
      <!--      </template>-->

      <div class="py-12">
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
               <!--               <welcome/>-->
               <div style="padding: 0.5em; justify-content: end">
                  <label for="file" style="margin-right: 0.5em" class="inline-flex items-center
                   px-1 py-2 bg-indigo-500 border border-transparent
                  rounded-md font-semibold text-sm text-white uppercase tracking-widest
                  hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900
                  focus:ring focus:ring-gray-300 disabled:opacity-25 transition custom-file-upload">
                     <input type="file" id="file" ref="file" v-on:change="importExcel()"/> Import
                  </label>
                  <input v-model="filter" v-on:keyup.enter="loadTableData()" placeholder="Search..."
                         class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                          focus:ring-opacity-10 rounded-md shadow-sm px-1 py-2 inline-flex items-center
                           border border-transparent font-semibold text-sm tracking-widest active:bg-gray-900
                            focus:outline-none disabled:opacity-25 transition"
                         style="margin-right: 0.5em; max-width: 150px"/>
                  <!--                  <multiselect-->
                  <!--                      v-model="selected"-->
                  <!--                      :options="options"-->
                  <!--                     class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200-->
                  <!--                          focus:ring-opacity-10 rounded-md shadow-sm px-4 py-2 inline-flex items-center-->
                  <!--                           border border-transparent font-semibold text-sm tracking-widest active:bg-gray-900-->
                  <!--                            focus:outline-none disabled:opacity-25 transition">-->
                  <!--                  </multiselect>-->
                  <select v-model="optionsFilter" v-on:keyup.enter="loadTableData()"
                          class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                          focus:ring-opacity-10 rounded-md shadow-sm px-1 py-2 inline-flex items-c
                          enter
                           border border-transparent font-semibold text-sm tracking-widest active:bg-gray-900
                            focus:outline-none disabled:opacity-25 transition"
                          style="min-width: 150px; margin-right: 0.5em">
                     <option v-for="item in options" :label="item" :value="item"></option>
                  </select>
                  <button-lite
                      @click="currentPage > 0 ? table.rows = chunkedData[--currentPage] : ''"
                      style="">
                     {{ '<-' }}
                  </button-lite>
                  <div class="border-gray-300 focus:border-indigo-300 shadow-sm px-1 py-2 inline-flex items-center
                           border border-transparent font-semibold text-sm tracking-widest active:bg-gray-900
                            focus:outline-none disabled:opacity-25 transition">
                     {{ this.currentPage + 1 }}
                  </div>
                  <button-lite
                      @click="currentPage < chunkedData.length -1 ? table.rows = chunkedData[++currentPage] : ''"
                      style="margin-right: 0.5em">
                     {{ '->' }}
                  </button-lite>

                  <!-- maybe and just maybe group these -->
                  <button-lite @click="exportToPdf()" style="float: right; background: #1a202c">Export PDF</button-lite>
                  <button-lite @click="exportToJson()" style="float: right; margin-right: 0.5em">Export JSON
                  </button-lite>
                  <button-lite @click="exportToXml()" style="float: right; margin-right: 0.5em">Export XML
                  </button-lite>
                  <input v-model="filename" placeholder="File name..."
                         class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                          focus:ring-opacity-10 rounded-md shadow-sm px-1 py-2 inline-flex items-center
                           border border-transparent font-semibold text-sm tracking-widest active:bg-gray-900
                            focus:outline-none disabled:opacity-25 transition"
                         style="margin-right: 0.5em; max-width: 150px; float: right"/>
               </div>
               <!-- Data Table -->
               <table-lite
                   :has-checkbox="false"
                   :is-loading="table.isLoading"
                   :is-re-search="table.isReSearch"
                   :columns="table.columns"
                   :rows="filteredTableData"
                   :total="table.totalRecordCount"
                   :sortable="table.sortable"
                   :messages="table.messages"
                   @click="doSearch($event)"
                   @is-finished="tableLoadingFinish"
                   @return-checked-rows="updateCheckedRows"
               />
               <!--               <button-lite-->
               <!--                   @click="currentPage > 0 ? table.rows = chunkedData[&#45;&#45;currentPage] : ''"-->
               <!--                   style="margin-right: 0.5em">-->
               <!--                  {{ '<-' }}-->
               <!--               </button-lite>-->
               <!--               <button-lite-->
               <!--                   @click="currentPage < chunkedData.length -1 ? table.rows = chunkedData[++currentPage] : ''"-->
               <!--                   style="margin-right: 0.5em">-->
               <!--                  {{ '->' }}-->
               <!--               </button-lite>-->

            </div>
         </div>
      </div>
   </app-layout>
</template>

<script>
import AppLayout from '../Layouts/AppLayout'
import Welcome from '../Layouts/AppLayout'
import TableLite from "vue3-table-lite";
import {defineComponent, reactive} from "vue";
import ButtonLite from '../Jetstream/Button'
import InputLite from '../Jetstream/Input'
import Multiselect from '@suadelabs/vue3-multiselect'
import Dropdown from "../Jetstream/Dropdown"
import Axios from 'axios'
import fileDownload from 'js-file-download'
import Input from "../Jetstream/Input";

function test() {
   console.log(this.table.rows)
}

export default defineComponent({
   name: "TermsOfService",
   data() {
      return {
         importFile: null,
         selected: null,
         options: [
            'All',
            '0 - 50',
            '50 - 200',
            '200 - 1000',
            '1000 - 5000'
         ],
         optionsFilter: 'All',
         filter: '',
         filename: '',
         chunkSize: 10,
         chunkedData: [],
         currentPage: 0,
         table: reactive({
            isLoading: false,
            isReSearch: false,
            columns: [
               {
                  label: "Name",
                  field: "name",
                  width: "15%",
                  sortable: true,
                  isKey: true,
                  display: function (row) {
                     return (
                         '<a href="#" data-id="' +
                         row.user_id +
                         '" class="is-rows-el name-btn">' +
                         row.name +
                         "</button>"
                     );
                  },
               },
               {
                  label: "Price",
                  field: "price",
                  width: "5%",
                  sortable: true,
                  isKey: true,

               },
               {
                  label: "Description",
                  field: "description",
                  width: "25%",
                  sortable: true,
               },
               {
                  // in_stock?
                  label: "Active",
                  field: "is_active",
                  width: "5%",
                  sortable: false,
               },
               // {
               //    label: "Actions",
               //    field: "quick",
               //    width: "3%",
               //    sortable: false,
               //    display: function (row) {
               //       return (
               //           '<button @click="" type="button" data-id="' +
               //           row.user_id +
               //           '" class="is-rows-el quick-btn">Sell</button>'
               //       );
               //    },
               // },
            ],
            rows: [],
            totalRecordCount: 5,
            sortable: {
               order: 'name',
               sort: "asc",
            },
            headerSort: [],
            messages: {
               pagingInfo: "Showing {0}-{1} of {2}",
               pageSizeChangeLabel: "Row count:",
               gotoPageLabel: "  Go to page:",
               noDataAvailable: "No data",
            }
         })
      }
   },
   props: ['terms'],
   components: {
      Input,
      AppLayout,
      TableLite,
      ButtonLite,
      InputLite,
      Multiselect,
      Dropdown,
   },
   methods: {
      doChunk(data) {
         if (data.length == 0) return;

         let chunkedArray = [];
         let previousChunk = 0;

         for (let i = 0; i < Math.ceil(data.length / 10); i++) {

            let tempArray = [];

            for (let j = previousChunk; j < previousChunk + this.chunkSize; j++) {
               if (!data[j]) break;
               tempArray.push(data[j])
            }

            chunkedArray[i] = tempArray
            previousChunk += this.chunkSize;
         }

         return chunkedArray;
      },
      importExcel() {
         // this.importFile = this.$refs.file
         // console.log(this.importFile)
         // return
         this.importFile = this.$refs.file.files[0];
         let data = new FormData();
         data.append('file', this.importFile);

         axios.post('http://localhost:8000/file-import', data)
         alert('Success')

         // .then(function (response) {
         //    console.log(response, "responz")
         // })
      },
      importExcel2() {
         // FILE VALIDATON???
         console.log('changed')

         let file = document.getElementById('file').files[0];
         let formData = new FormData();

         formData.append("file", file);
         fetch('http://localhost:8000/file-import', {method: "POST", body: formData});

         // window.location.href = 'http://localhost:8000/file-import'
         // window.location.href = 'http://localhost:8000/file-import-export'
      },
      // exportToXml(url, filename)
      exportToXml() {
         if (this.filteredTableData.length != 0) {
            let filename = this.filename
            if (filename == '') {
               filename = 'file'
            }
            // console.log(axios.defaults.baseURL = process.env.APP_URL)
            Axios({
               url: 'http://localhost:8000/exportToXml',
               method: 'POST',
               data: {items: this.filteredTableData},
               responseType: 'blob',
            }).then(function (response) {
               fileDownload(response.data, filename + '.xml');
            });
         }
      },
      // final export to json
      exportToJson() {
         if (this.filteredTableData.length != 0) {
            let filename = this.filename
            if (filename == '') {
               filename = 'file'
            }
            fileDownload(JSON.stringify(this.filteredTableData), filename + '.json');
         }
      },
      // exportToJson(exportObj, exportName)
      exportToJson2() {
         const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(this.filteredTableData));
         const downloadAnchorNode = document.createElement('a');
         downloadAnchorNode.setAttribute("href", dataStr);
         downloadAnchorNode.setAttribute("download", 'exportName' + ".json");
         document.body.appendChild(downloadAnchorNode); // required for firefox
         downloadAnchorNode.click();
         downloadAnchorNode.remove();
      },
      exportToJson3() {
         const saveTemplateAsFile = (filename, jsonToWrite) => {
            const blob = new Blob([jsonToWrite], {type: "text/json"});
            const link = document.createElement("a");

            link.download = filename;
            link.href = window.URL.createObjectURL(blob);
            link.dataset.downloadurl = ["text/json", link.download, link.href].join(":");

            const evt = new MouseEvent("click", {
               view: window,
               bubbles: true,
               cancelable: true,
            });

            link.dispatchEvent(evt);
            link.remove()
         };
      },
      // TODO pdf export
      exportToPdf() {
         if (this.filteredTableData.length != 0) {
            let filename = this.filename
            if (filename == '') {
               filename = 'file'
            }
            Axios({
               url: 'http://localhost:8000/exportToPdf',
               method: 'POST',
               data: {items: this.filteredTableData},
               // responseType: 'blob',
            }).then(function (response) {
               // fileDownload(response.data, filename + '.pdf');
               console.log(response.data)
            });
         }
      },
      // fill the table rows from inertia page prop rendered in page controller
      loadTableData() {
         this.table.rows = this.$inertia.page.props.products
         this.chunkedData = this.doChunk(this.$inertia.page.props.products)
         this.table.rows = this.chunkedData.length !== 0 ? this.chunkedData[0] : []
      },
      // perfectly working column sort
      doSearch(event) {
         let headerName = event.srcElement.innerText.toLowerCase();

         this.table.rows = this.table.rows.sort(function (row1, row2) {
            switch (typeof row1[headerName]) {
               case "number":
                  if (row1[headerName] > row2[headerName]) {
                     // console.log(row1[headerName], row2[headerName])
                     return row2[headerName] - row1[headerName];
                  }
                  return row1[headerName] - row2[headerName];
               case "string":
                  return -1;
            }
         })

         // purple arrow configuration
         this.table.sortable.order = headerName;
         if (this.table.sortable.sort == 'asc') {
            this.table.sortable.sort = 'desc';
         } else {
            this.table.sortable.sort = 'asc';
         }
      },
      tableLoadingFinish(elements) {
         this.table.isLoading = false;
      },
      updateCheckedRows(rowsKey) {
         // console.log(rowsKey)
      },
      // returns the number searched for if found in given range
      findNumberInRange($price, $range) {
         let $first = parseInt($range.split(' - ')[0]);
         let $second = parseInt($range.split(' - ')[1]);

         if ($price >= $first && $price <= $second) {
            return $price;
         }
         return 0;
      },
      debugging(something) {
         console.log(something)
      }
   },
   created() {
      this.loadTableData()
      this.table.headerSort['name'] = 'asc'
      this.table.headerSort['price'] = 'asc'
      this.table.headerSort['description'] = 'asc'
   },
   computed: {
      filteredTableData() {
         const searchTerm = this.filter.toLowerCase();
         const searchOption = this.optionsFilter.toLowerCase()

         // filter table data by search string for item name and description
         let termFiltered = this.table.rows.filter(row => {
            return row.name.toLowerCase().includes(searchTerm) || row.description.toLowerCase().includes(searchTerm)
         });

         if (searchOption == 'all') {
            return termFiltered;
         }

         // applies price range filter to previously filtered data
         return termFiltered.filter(row => {
            const searchPrice = row.price;

            const result = this.findNumberInRange(searchPrice, searchOption);

            if (result == searchPrice) {
               return true;
            }
         });

      },
      testCom: function () {
         return console.log('computed ')
      }

   }
})

</script>
<style>
.termsofservice {
   font-family: Avenir, Helvetica, Arial, sans-serif;
   -webkit-font-smoothing: antialiased;
   -moz-osx-font-smoothing: grayscale;
   text-align: center;
   color: #2c3e50;
}

.slider {
   /* overwrite slider styles */
   width: 200px;
}

input[type="file"] {
   display: none;
}

.custom-file-upload {
   cursor: pointer;
}

</style>