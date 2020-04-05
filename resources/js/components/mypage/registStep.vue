<template>
  <div class="p-panel__group">
     <a class="p-panel__link"  :href="/step/ + registSteps.id + '/edit'">
       <div class="p-panel__category">
         <p>{{ this.registSteps.category.name }}</p>
       </div>
       <div class="p-panel__header">
         <h2 class="p-panel__header--title">{{registSteps.title}}</h2>
       </div>
         <img class="p-panel__img" :src="showImg" alt="">
       <div class="p-panel__body">
         <p>目安時間:{{ registSteps.time }}時間</p>
         <p>全ステップ数:{{ registSteps.child_steps.length }}回</p>
         <button class="c-btn__btn--delete" @click="onSubmit">削除</button>
       </div>
     </a>
   </div>
</template>
<script>
export default {
  props:['registSteps'],
  data: function(){
    return{
      showImg: this.registSteps.img ? this.registSteps.img : '/img/no-img.png'
    }
  },
  methods:{
    onSubmit: function(){
      if(!confirm('本当にこのステップを削除しますか？')){
        event.preventDefault();
        return;
      }
      //axios通信
      axios.post('/step/' + this.registSteps.id + '/delete').then(res=>{
        console.log(res);
        location.href = '/mypage';
      }).catch(err=>{
        console.log(err.response.data.errors);
      });
    }
  }
}
</script>