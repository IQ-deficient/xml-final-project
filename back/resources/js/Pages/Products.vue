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
                  <button-lite @click="importExcel()" style="margin-right: 0.5em">Import</button-lite>
                  <input v-model="filter" v-on:keyup.enter="loadTableData()" placeholder="Search..."
                         class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                          focus:ring-opacity-10 rounded-md shadow-sm px-4 py-2 inline-flex items-center
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
                          focus:ring-opacity-10 rounded-md shadow-sm px-4 py-2 inline-flex items-center
                           border border-transparent font-semibold text-sm tracking-widest active:bg-gray-900
                            focus:outline-none disabled:opacity-25 transition"
                          style="min-width: 150px">
                     <option v-for="item in options" :label="item" :value="item"></option>
                  </select>
                  <!-- maybe and just maybe group these -->
                  <button-lite @click="exportToPdf()" style="float: right">Export PDF</button-lite>
                  <button-lite @click="exportToJson()" style="float: right; margin-right: 0.5em">Export JSON
                  </button-lite>
                  <button-lite @click="exportToXml()" style="float: right; margin-right: 0.5em">Export XML</button-lite>
               </div>
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

export default defineComponent({
   name: "TermsOfService",
   data() {
      return {
         selected: null,
         options: [
            'All',
            '0 - 50',
            '50 - 200',
            '200 - 1000',
            '1000 and up'
         ],
         optionsFilter: 'All',
         filter: '',
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
            totalRecordCount: 20,
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
      AppLayout,
      TableLite,
      ButtonLite,
      InputLite,
      Multiselect,
      Dropdown,
   },
   methods: {
      importExcel() {
         console.log("IMPORT")
      },
      // exportToXml(url, filename)
      exportToXml() {
         Axios({
            url: 'http://localhost:8000/exportToXml',
            method: 'POST',
            data: {items: this.filteredTableData},
            responseType: 'blob',
         }).then(function (response) {
            console.log(response.data)
            // fileDownload(response, 'report.json');
         });
      },
      // final export to json
      exportToJson() {
         fileDownload(JSON.stringify(this.filteredTableData), 'report.json');
      },
      exportToJson1() {
         // const fileDownload = require('js-file-download');
         Axios({
            url: 'http://localhost:8000/exportToJson',
            method: 'POST',
            data: {items: this.filteredTableData},
            responseType: 'blob', // Important
         }).then((response) => {
            fileDownload(response.data, 'report.json');
         });
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
      exportToPdf() {
         console.log('PDF')
      },
      // fill the table rows from inertia page prop rendered in page controller
      loadTableData() {
         this.table.rows = this.$inertia.page.props.products
         this.table.totalRecordCount = this.$inertia.page.props.products.length
      },
      // perfectly working column sort
      doSearch(event) {
         let headerName = event.srcElement.innerText.toLowerCase();

         this.table.rows = this.table.rows.sort(function (row1, row2) {
            switch (typeof row1[headerName]) {
               case "number":
                  if (row1[headerName] > row2[headerName]) {
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
   }
   ,
   computed: {
      filteredTableData() {
         const searchTerm = this.filter.toLowerCase();
         const searchOption = this.optionsFilter.toLowerCase();

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
</style>