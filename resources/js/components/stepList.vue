<template>

    <section class="u-bg--default">
        <div class="c-container">
          <div class="p-search__container">
            <div class="p-search">
              <span class="p-search__title">タイトル検索 :</span><input class="p-search__input" type="text" v-model="keywords">
            </div>
            <div class="p-search">
              <span class="p-search__title">カテゴリー検索 :</span>
              <select class="p-search__select" v-model="category_name" >
                <option value="">すべて</option>
                <option v-for="category in categories" :key="category.id" :value="category.name" >
                  {{ category.name }}
                  </option>
              </select>
            </div>
          </div>
          

                <!-- 　チャレンジ中のステップが無い場合 -->
            <div style="text-align:center" v-if="getItems.length === 0">
              <p class="u-fontsize--xl">STEPが見つかりません</p>
            </div>
          <div class="p-panel__container">
            <stepListPanel
              v-for="parentSteps in getItems"
              :key="parentSteps.id"
              :parentSteps="parentSteps"
            ></stepListPanel>
          </div> 
              <paginate
                :page-count="getPageCount"
                :page-range="3"
                :margin-pages="2"
                :click-handler="clickCallback"
                :prev-text="null"
                :next-text="null"
                :container-class="'pagination'"
                :page-class="'page-item'"
                :page-link-class="'page-link-item'"
                >
              </paginate>
        </div>
      </section>
</template>
<script>
import stepListPanel from './stepListPanel';
import Paginate from 'vuejs-paginate'
Vue.component('paginate', Paginate);
export default {
  components:{
    stepListPanel
  },
  props: ['parentStepData', 'categories', 'authFlg'],
  data: function(){
    return{
      parentSteps: this.parentStepData,
      keywords: '',
      category_name: '', 
      items: this.filterdParentStep,
      parPage: 6, //　１ページに表示するアイテム数
      currentPage: 1
    }
  },
  computed:{
    // 検索機能
    filterdParentStep: function(){
      var parentSteps = [];
      for(var i in this.parentSteps){
        var parentStep = this.parentSteps[i];
        if(parentStep.title.indexOf(this.keywords) !== -1 &&
            parentStep.category.name.indexOf(this.category_name) !== -1){
          parentSteps.push(parentStep);
        }
      }
      return parentSteps;
    },
    // ページネーション
    getItems: function(){ 
      let current = this.currentPage * this.parPage;
      let start = current - this.parPage;
      return this.filterdParentStep.slice(start, current);
    },
    getPageCount: function(){
      return Math.ceil(this.filterdParentStep.length / this.parPage);
    }
  },
  methods:{
    clickCallback: function(pageNum){
      this.currentPage = Number(pageNum);
    }
  }
}
</script>