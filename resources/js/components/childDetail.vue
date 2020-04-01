<template>
  <div class="u-bg--default">
        <section class="c-container">
          <div class="p-detail__container">
            <div class="p-detail__container--main">
              <h2 class="p-detail__title">STEP:{{ (childStepDetail.num < 9) ? '0' + childStepDetail.num : childStepDetail.num }}</h2>
              <h3 class="p-detail__title">「 {{childStepDetail.title}} 」</h3>
              <div class="p-detail__content"><p>{{childStepDetail.content}}</p>
              </div>
              <p class="p-detail__time">目安達成時間:{{time}}時間</p>
              <div class="c-btn c-btn__container--right">
                <template v-if="authFlg && challengeFlg && !clearFlg">
                <button type="submit" class="c-btn__btn--success" @click="onSubmit">クリア！</button>
                </template>
                <template v-if="authFlg && challengeFlg && clearFlg">
                <button type="submit" class="c-btn__btn--done">クリア済み</button>
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
          <userProf
          :userProf="userProf"
          >
          </userProf>
        </section>
  </div>
</template>
<script>
import userProf from './ParentDetail/userProf';
import childTitle from './ParentDetail/childTitle'
export default {
  props:['childSteps','childStepDetail','userProf','parentStep', 'authFlg','challengeFlg','clearFlg'],
  components:{
    childTitle,
    userProf
  },
  computed:{
    time: function(){
      let time = 0;
      time = this.childStepDetail.time / 60;
      return time;
    }
  },
  methods:{
    onSubmit: function(){
      let data = {
        'child_id' : this.childStepDetail.id
        }
      let config = {
        headers: {
          'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      };
      // クリアを押したら次のステップに遷移するが、次のステップがあるかどうか判定するために全子ステップのナンバーを配列に格納する
      let childsteps_num = [];
      for(var i = 0; i < this.childSteps.length; i++){
        childsteps_num.push(this.childSteps[i].num)
       }
       
      //axios通信
      axios.post('/clear', data, config).then(res => { 
        console.log(res);
        if(childsteps_num.indexOf(this.childStepDetail.num+1) >= 0){ //もし次のステップのnumが配列内にあったら
          location.href = '/step/'+ this.parentStep.id + '/' + (this.childStepDetail.id + 10);
        }else{
          location.href = '/mypage';
        }
      })
      .catch(err => {
        this.errs = err.response.data.errors;
        console.log(err.response.data.errors);
      });
    }
  }
}
</script>