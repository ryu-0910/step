<template>
<div class="u-bg--default">
  <section class="p-hero">
    <h2 class="p-hero__title"><span>「</span>あなたの人生の<br>STEPを共有しよう<span>」</span> </h2>
  </section>
  <section class="p-index__container">
      <h2 class="c-container__title">ABOUT</h2>
      <p class="p-index__content">プログラミングや英語など、なにを学ぶのにも人それぞれ「これが良かった」という「順番」と「内容」があります。</p>
      <p class="p-index__content"> このサービスは、人それぞれの「この順番でこういったものを学んでいったのが良かった」という「STEP」を投稿し、
         他の人はそれを見ながらその「STEP」を元に学習を進めていけるサービスです。<br>
        今はインターネットも普及し、情報がいくらでも手に入る。そんな時代だからこそ、いざ学習を始めようと思っても
      <p class="p-index__content u-font--bold">いったい何から始めていいのかわからない・・・</p>
      <p class="p-index__content u-font--bold">どんな順番で進めたらいいのかわからない・・・</p>
      <p class="p-index__content">そんな悩みをこのサービスで解決できるかもしれません。また、あなたの学習のSTEPを必要としている人が必ずいます。<br>
      あなたの人生の「STEP」を共有しましょう</p> 
  </section>
  <section class="u-bg--white">
    <div class="p-index__container">
      <h2 class="c-container__title">MERIT</h2>
      <div class="p-index__panel-group" v-inview:parent="'animate'">
        <div class="p-index__panel" :animate-toggle="'fadeInLeft'">
          <h3 class="p-index__panel-title">進捗が管理できる！</h3>
          <div class="p-index__panel-content">
            <p>学習を始める際、自分の学びたい「STEP」を選び「チャレンジ」することができます。<br>
            また、学習が終了し「クリア」することで自分の学習の「進捗」を簡単に管理できモチベーションを保ちながら学習することが可能です。
            </p>
          </div>
        </div>
        <div class="p-index__panel"  :animate-toggle="'fadeInLeft'">
          <h3 class="p-index__panel-title">目安時間がわかる！</h3>
          <div class="p-index__panel-content">
            <p>
              何かを学習するにあたって、誰しもが苦労するのが「時間」を作ること。
              特に社会人の方は仕事をしながら勉強をすることがほとんどで、多くの人が学習終了するまでに
              かかる時間というのは気になるところだと思います。<br>この「STEP」では、「目安時間」を見ることができ、
              時間が無い方でもそのライフスタイルにあった最適な学習時間内で学習することができます。
            </p>
          </div>
        </div>
        <div class="p-index__panel" :animate-toggle="'fadeInLeft'">
          <h3 class="p-index__panel-title">体系的に学べる！</h3>
          <div class="p-index__panel-content ">
            <p>
              学習の順序はとても大事です。
              どの内容をどのタイミングで学習すればいいのかわからない、というのはとても非効率。<br>
              しかし、「STEP」では学習の順序がわかり体系的に学んでいくことができるため、とても効率的に学習していくことができます。
            </p>
          </div>
        </div>
        <span class="p-index__text">※STEPの投稿やチャレンジには無料ユーザー登録が必要です。</span>
      </div> 
    </div>
  </section>
  <div v-inview:parent="'animate'">
    <section class="p-index__title--relative" style="animation-duration: 2s;" :animate-toggle="'fadeIn'">
      <h2 class="p-index__title--absolute">STEPLIST</h2>
      <stepList
        :parentStepData="parentStepData"
        :categories="categories"
        >
      </stepList>
  </section>
  </div>
</div>

</template>
<script>
import stepList from '../stepList'
import Inview from 'vueinview'
Vue.use(Inview);
export default {
  components:{
    stepList
  },
  props:['parentStepData','categories'],
  
}

</script>