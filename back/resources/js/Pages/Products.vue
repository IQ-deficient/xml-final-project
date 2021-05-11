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
               <table-lite
                   :has-checkbox="false"
                   :is-loading="table.isLoading"
                   :is-re-search="table.isReSearch"
                   :columns="table.columns"
                   :rows="table.rows"
                   :total="table.totalRecordCount"
                   :sortable="table.sortable"
                   :messages="table.messages"
                   @do-search="doSearch"
                   @is-finished="tableLoadingFinish"
                   @return-checked-row="updateCheckedRows"
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

export default defineComponent({
   name: "TermsOfService",
   data() {
      return {}
   },
   props: ['terms'],
   components: {
      AppLayout,
      TableLite
   },
   setup() {
      const table = reactive({
         isLoading: false,
         isReSearch: false,
         columns: [
            {
               label: "Name",
               field: "name",
               width: "15%",
               sortable: true,
               // isKey: true,
            },
            {
               label: "Price",
               field: "price",
               width: "5%",
               sortable: true,
               display: function (row) {
                  return (
                      '<a href="#" data-id="' +
                      row.product_id +
                      '" class="is-rows-el name-btn">' +
                      row.name +
                      "</button>"
                  );
               },
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
               label: "Operation",
               field: "quick",
               width: "5%",
               display: function (row) {
                  return (
                      '<button type="button" data-id="' +
                      row.user_id +
                      '" class="is-rows-el quick-btn">Button</button>'
                  );
               },
            },
         ],
         rows: sampleData1(0, 10),
         totalRecordCount: 20,
         sortable: {
            order: "name",
            sort: "asc",
         },
         messages: {
            pagingInfo: "Showing {0}-{1} of {2}",
            pageSizeChangeLabel: "Row count:",
            gotoPageLabel: "  Go to page:",
            noDataAvailable: "No data",
         },
      });

      const doSearch = (offset, limit, order, sort) => {
         table.isLoading = true;
         setTimeout(() => {
            table.isReSearch = offset == undefined ? true : false;
            if (offset >= 10 || limit >= 20) {
               limit = 20;
            }
            if (sort == "asc") {
               table.rows = sampleData1(offset, limit);
            } else {
               table.rows = sampleData2(offset, limit);
            }
            table.totalRecordCount = 20;
            table.sortable.order = order;
            table.sortable.sort = sort;
         }, 600);
      };

      /**
       * @param Collection elements 靜態元件
       */
      const tableLoadingFinish = (elements) => {
         table.isLoading = false;
         Array.prototype.forEach.call(elements, function (element) {
            if (element.classList.contains("name-btn")) {
               element.addEventListener("click", function () {
                  console.log(this.dataset.id + " name-btn click!!");
               });
            }
            if (element.classList.contains("quick-btn")) {
               element.addEventListener("click", function () {
                  console.log(this.dataset.id + " quick-btn click!!");
               });
            }
         });
      };

      const updateCheckedRows = (rowsKey) => {
         console.log(rowsKey);
      };

      return {
         table,
         doSearch,
         tableLoadingFinish,
         updateCheckedRows,
      };
   },
})

const loadTableData = (offst, limit) => {
   axios.get().then(response => {
      offst = offst + 1;
      let data = [];
      this.tableData = response.data
      for (let i = offst; i <= limit; i++) {
         data.push({
            name: response.data.name,
            price: response.data.price,
            description: response.data.description,
            is_active: response.data.is_active,
         });
      }
      return data;
   }).catch(error => {
      console.log(error)
   })
};

const sampleData1 = (offst, limit) => {
   offst = offst + 1;
   let data = [];
   for (let i = offst; i <= limit; i++) {
      data.push({
         // id: i,
         name: "name " + i,
         price: "1"+ i,
         description: "desc " +1,
         is_active: true,
         // email: "test" + i + "@example.com",
      });
   }
   return data;
};

const sampleData2 = (offst, limit) => {
   let data = [];
   for (let i = limit; i > offst; i--) {
      data.push({
         id: i,
         name: "TEST" + i,
         email: "test" + i + "@example.com",
      });
   }
   return data;
};

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