<template>
   <section class="p-prof__container">
            <h3 class="p-prof__title">このSTEPの登録者:  {{ userProf.name }} さん</h3>
            <div class="p-prof__wrap">
              <img :src="showImg" alt="" class="p-prof__img">
              <div class="p-prof__content">{{ userProf.intro }}</div>
            </div>
    </section>
</template>
<script>
export default {
  props:['userProf'],
  data: function(){
    return{
      showImg: this.userProf.img ? '/storage/img/' + this.userProf.img : '/img/no-img.png'
    }
  }
}
</script>