<template>
  <div class="p-panel__group">
      <a class="p-panel__link" :href="/step/ +challengeSteps.id">
        <div class="p-panel__category">
          <p>{{ challengeSteps.category.name }}</p>
        </div>
        <div class="p-panel__header">
          <h2 class="p-panel__header--title">{{ challengeSteps.title }}</h2>
        </div>
          <img class="p-panel__img" :src="showImg" alt="">
        <div class="p-panel__body">
          <p>完了数: {{ clearSum }}/{{ child_sum }} STEP</p>
          <div class="p-panel__progress">
            <div class="p-panel__progress--bar" :style="{width: progress + '%'}">
              <span class="p-panel__progress--value">{{ progress }}%</span>
            </div>
          </div>
          <p>目安時間:{{ challengeSteps.time }}時間</p>
        </div>
       </a>
  </div>
</template>
<script>
export default {
  props:['challengeSteps'],
  data: function(){
    return{
      showImg: this.challengeSteps.img ?  this.challengeSteps.img : '/img/no-img.png',
      child_sum: this.challengeSteps.child_steps.length,
    }
  },
    computed:{
    clearSum: function(){
      // クリアした子ステップの合計数を配列数から計算
      let clear_sum = 0;
      for(let i = 0; i < this.child_sum; i++){
        clear_sum += this.challengeSteps.child_steps[i].clears.length;
      }
      return  clear_sum
    },
    progress: function(){
      // 進捗をクリア数 / チャレンジ中のステップ数で計算
      return Math.round(this.clearSum / this.child_sum * 100);
    }
  }
}

</script>