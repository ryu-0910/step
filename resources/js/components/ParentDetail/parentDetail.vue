<template>
  <div class="u-bg--default">
        <section class="c-container">
          <h2 class="c-container__title">「 {{parentStep.title}} 」</h2>
          <!-- 親ステップ内容 -->
          <div class="p-detail__container">
            <div class="p-detail__container--main">
              <h3 class="p-detail__category">{{parentStep.category.name}}</h3>
              <img class="p-detail__img" :src="showImg" alt="">
              <div class="p-detail__content"><p>{{parentStep.content}}</p></div>
              <p class="p-detail__time">目安達成時間: {{parentStep.time }}時間</p>
              <!-- チャレンジボタン(認証ずみまたはクリア済みかで切り替え) -->
              <div class="c-btn__container--right">
                <template v-if="authFlg && !challengeFlg">
                <button type="submit" class="c-btn__btn--success" @click="onSubmit">チャレンジ！</button>
                </template>
                <template v-else-if="authFlg && challengeFlg">
                <button type="submit" class="c-btn__btn--done">チャレンジ中</button>
                </template>
              </div>
            </div>
            <!-- 子ステップリスト -->
            <div class="p-detail__container--side">
              <h3 class="p-side__title">STEP順序</h3>
              <childTitle
              v-for="childSteps in childSteps"
              :key="childSteps.id"
              :parentStep="parentStep"
              :childSteps="childSteps"
              ></childTitle>
            </div>
          </div>
          <!-- 作成ユーザー紹介 -->
          <userProf
          :userProf="userProf"
          >
          </userProf>
        </section>

        
    </div>
</template>
<script>
import childTitle from './childTitle';
import userProf from './userProf';
export default {
  props:['parentStep','childSteps','userProf', 'authFlg', 'challengeFlg'],
  components:{
    childTitle,
    userProf
  },
  data: function(){
    return{
      showImg: this.parentStep.img ? '/storage/img/' + this.parentStep.img : '/img/no-img.png'
    }
  },
  methods: {
    onSubmit: function(){
      let data = { step_id : this.parentStep.id };
      let config = {
        headers: {
          'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      };
      //axios通信
      axios.post('/challenge', data, config).then(res => {
        console.log(res);
        location.href = '/step/'+ this.parentStep.id + '/' + this.childSteps[0].id;
      })
      .catch(err => {
        this.errs = err.response.data.errors;
        console.log(err.response.data.errors);
      });
    }
  }
}

</script>