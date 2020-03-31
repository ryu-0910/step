<template>
  <div class="u-bg--default">
        <div class="c-container">
          <h2 class="c-container__title">チャレンジ中のステップ</h2>
            <div class="p-panel__container">
              <!-- チャレンジ中のステップ -->
              <challengeStep
              v-for="challengeSteps in challengeSteps"
              :key="challengeSteps.id"
              :challengeSteps="challengeSteps">
              </challengeStep>
          </div>
             <!-- 　チャレンジ中のステップが無い場合 -->
            <div style="text-align:center" v-if="challengeSteps.length === 0">
              <p class="u-fontsize--l u-p-bottom_l">チャレンジ中のステップがありません</p>
            </div>
        
          <h2 class="c-container__title">登録したステップ</h2>
          <div class="p-panel__container">
            <!-- 登録したステップ -->
            <registStep
            v-for="registSteps in registSteps"
              :key="registSteps.id"
              :registSteps="registSteps">
            </registStep>
          </div>
          <!-- 登録中のステップが無い場合 -->
            <div style="text-align:center" v-if="registSteps.length === 0">
              <p class="u-fontsize--l u-p-bottom_l">登録したステップがありません</p>
            </div>
        </div>
    </div>
</template>
<script>
import registStep from './registStep';
import challengeStep from './challengeStep';
export default {
  components:{
    registStep,
    challengeStep
  },
  props:['challengeSteps', 'registSteps']
}
</script>