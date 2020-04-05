<template>
    <div class="p-panel__group">
      <a class="p-panel__link" :href="/step/ + parentSteps.id">
        <div class="p-panel__category">
          <p>{{ parentSteps.category.name }}</p>
        </div>
        <div class="p-panel__header">
          <h2 class="p-panel__header--title">{{parentSteps.title}}</h2>
        </div>
          <img class="p-panel__img" :src="showImg" alt="">
        <div class="p-panel__body">
          <p>目安時間:{{parentSteps.time}}時間</p>
          <p>全ステップ数:{{parentSteps.child_steps.length}}回</p>
        </div>
      </a>
    </div>
</template>
<script>
export default {
  props:['parentSteps','categoryData'],
  data: function(){
    return{
      showImg: this.parentSteps.img ? this.parentSteps.img : '/img/no-img.png',
    }
  }
}
</script>