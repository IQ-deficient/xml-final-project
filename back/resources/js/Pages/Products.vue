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
                  <button-lite style="margin-right: 0.5em">Import</button-lite>

                  <button-lite @click="exportToPdf()" style="float: right">Export PDF</button-lite>
                  <button-lite @click="exportToJson()" style="float: right; margin-right: 0.5em">Export JSON</button-lite>
                  <button-lite @click="exportToXml()" style="float: right; margin-right: 0.5em">Export XML</button-lite>
               </div>
               <table-lite
                   :has-checkbox="false"
                   :is-loading="table.isLoading"
                   :is-re-search="table.isReSearch"
                   :columns="table.columns"
                   :rows="table.rows"
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

export default defineComponent({
   name: "TermsOfService",
   data() {
      return {
         table: reactive({
            isLoading: false,
            isReSearch: false,
            columns: [
               {
                  label: "Name",
                  field: "name",
                  width: "10%",
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
                  width: "20%",
                  sortable: true,
               },
               {
                  label: "Active",
                  field: "is_active",
                  width: "5%",
                  sortable: false,
               },
               {
                  label: "",
                  field: "quick",
                  width: "5%",
                  sortable: false,
                  display: function (row) {
                     return (
                         '<button type="button" data-id="' +
                         row.user_id +
                         '" class="is-rows-el quick-btn">Sell</button>'
                     );
                  },
               },
            ],
            rows: [],
            totalRecordCount: 20,
            sortable: {
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
      ButtonLite
   },
   methods: {
      exportToXml() {

      },
      exportToJson() {

      },
      ExportToPdf() {

      },
      loadTableData() {
         this.table.rows = this.$inertia.page.props.products
         this.table.totalRecordCount = this.$inertia.page.props.products.length
      },
      doSearch(event) {
         let headerName = event.srcElement.innerText.toLowerCase();

         if (this.table.headerSort[headerName] === 'asc') {
            this.table.rows = this.table.rows.sort(function (row1, row2) {
               if (typeof row1[headerName] == 'number') {
                  return row2[headerName] - row1[headerName]
               } else if (typeof row1[headerName] == 'string') {
                  return -1;
               }
            })
            this.table.headerSort[headerName] = 'desc'
         } else {
            this.table.rows = this.table.rows.sort(function (row1, row2) {
               if (typeof row1[headerName] == 'number') {
                  return row1[headerName] - row2[headerName]
               } else if (typeof row1[headerName] == 'string') {
                  return 1;
               }
            })
            this.table.headerSort[headerName] = 'asc'
         }
         console.log(this.table.headerSort[headerName])

         // purple arrow configuration
         this.table.sortable.order = headerName;
         this.table.sortable.sort = this.table.headerSort[headerName];

      },
      tableLoadingFinish(elements) {
         this.table.isLoading = false;
      },
      updateCheckedRows(rowsKey) {
         // console.log(rowsKey)
      }
   },
   created() {
      this.loadTableData()
      this.table.headerSort['name'] = 'asc'
      this.table.headerSort['price'] = 'asc'
      this.table.headerSort['description'] = 'asc'
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
</style>