<template>
  <div class="u-bg--default">
      <div class="c-container">
        <div action="post" class="p-form">
          <!-- 親ステップ -->
          <h2 class="p-form__title">STEP{{ !editFlg ? '登録' : '編集' }}</h2>
          <!-- STEP画像 -->
          <p class="p-form__errmsg" v-if="errs.parent_img">
                {{errs.parent_img[0]}}
          </p>

          <div class="p-form__content">
            <span class="p-form__name">STEP画像</span>
            <div class="p-profile__avater">
              ドラッグ＆ドロップ
              <input type="file" name="parent.img" id="img" class="p-profile__avater--input" accept="image/*" @change="onFileChange" :class="errs.parent_img ? 'p-form__input--err': '' ">
              <img :src="parent.showImg" alt="" class="p-profile__avater--img">
            </div>
          </div>

          <!-- 親ステップタイトル -->
          <p class="p-form__errmsg" v-if="errs.parent_title">
                {{errs.parent_title[0]}}
          </p>
          <p class="p-form__errmsg" v-if="parent.title.length > 20">
                20文字以内で入力してください
          </p>
          <div class="p-form__content">
            <span class="p-form__name">タイトル
            </span>
            <input v-model="parent.title" type="text" class="p-form__input--text" name="title" id="title" :class="errs.parent_title || parent.title.length > 20 ? 'p-form__input--err': '' ">
          </div>

          <!-- カテゴリー -->
          <p class="p-form__errmsg" v-if="errs.parent_category">
                {{errs.parent_category[0]}}
          </p>
          <div class="p-form__content">
            <span class="p-form__name">カテゴリー</span>
            <select class="p-form__select" v-model="parent.category_id" :class="errs.parent_category ? 'p-form__input--err': '' ">
              <option value="">選択してください</option>
              <option v-for="category in categories" :key="category.id" :value="category.id" >
                {{ category.name }}
                </option>
            </select>
          </div>

          <!-- 親STEP紹介文 -->
          <p class="p-form__errmsg" v-if="errs.parent_content">
                {{errs.parent_content[0]}}
          </p>
           <p class="p-form__errmsg" v-if="parent.content.length > 191">
                191文字以内で入力してください
          </p>

          <div class="p-form__content" style="margin-bottom:0">
            <span class="p-form__name">STEP紹介文</span>
            <textarea v-model="parent.content" name="content" id="content" :class="errs.parent_content || parent.content.length > 191 ? 'p-form__input--err': '' " class="p-form__textarea"></textarea>
          </div>
          <p class="p-form__counter">※191文字以内で入力してください<br>{{ parent.content.length}} / 191</p>
        </div>
      

      <!-- 子ステップ -->
      <transition-group name="show">
       <childStep-register
          v-model="childSteps[index]"
          v-for="(childStep, index) in childSteps"
          :key="index"
          :index="index"
          :errs="errs"
          > 
       </childStep-register>
      </transition-group> 
        <div class="c-btn__container--around">
          <button class="c-btn__btn--success" @click="addChild">+ STEPを追加</button>
          <button class="c-btn__btn--default" @click="onSubmit">登録する</button>
        </div>

      </div>
    </div>
</template>
<script>
import childStepRegister from './childStepRegister'
export default {
  components:{
     childStepRegister
  },
  props:['categories', 'editFlg', 'parentStepData', 'childStepsData'],
  data: function(){
    return{
      parent:{
        img: '',
        showImg: '',
        title: '',
        category_id: '',
        content: '',
      },
      childSteps:[],
      errs:'',
    }
  },
  // フォームデータを初期化
  created: function(){
    // 親ステップデータ
    if(this.editFlg){
      this.parent.img = this.parentStepData[0].img ? this.parentStepData[0].img : '';
      this.parent.showImg = this.parentStepData[0].img ? '/storage/img/' + this.parentStepData[0].img : '';
      this.parent.title = this.parentStepData[0].title ? this.parentStepData[0].title : '';
      this.parent.category_id = this.parentStepData[0].category_id ? this.parentStepData[0].category_id : '';
      this.parent.content = this.parentStepData[0].content ? this.parentStepData[0].content :  '';
    }
    // 子ステップデータ
    if(this.editFlg){
      this.childStepsData.forEach(e =>{
        this.childSteps.push(e);
      })
    }else{
      const addform = {
        id: "",
        title: "",
        time: "",
        content: "",
      }
    this.childSteps.push(addform);
    }
    
  },
  methods:{
    //画像プレビュー
    onFileChange : function(e){
      //画像データの読み込み
      let files  = e.target.files;
      if(files.length > 0){ //ファイルが選択されたかチェック
        const file = files[0];
        const reader = new FileReader(); 
        reader.onload = e => {
          this.parent.showImg = e.target.result;
      };
      reader.readAsDataURL(file);
      }
      this.parent.img = files[0];
    },

    //子STEP入力フォーム追加
    addChild: function(){
      const addform = {
        id: "",
        title: "",
        time: "",
        content: "",
      }
    this.childSteps.push(addform);
    },
    onSubmit : function(){
      //フォームへの入力データを追加
      let data = new FormData();

      //子ステップの目安時間を全て足し、親ステップの目安時間としてデータに追加
      let parent_time = 0
      for(var i = 0; i < this.childSteps.length; i++){
        parent_time += this.childSteps[i].time;
      } 
      parent_time = parent_time/60;// 分から時間に直す
      // 親ステップデータを格納
      // 画像更新しない(dataがアップロードパス)時はimageバリデーションに引っかかるため更新しない
      typeof this.parent.img === 'string' ? false : data.append('parent_img', this.parent.img);
      data.append('parent_title', this.parent.title);
      data.append('parent_category', this.parent.category_id);
      data.append('parent_content', this.parent.content);
      data.append('parent_time', parent_time);

      // 子ステップデータを格納 
      let sum = this.childSteps.length; //apiでDB登録する際にループする回数として、子ステップのデータ数を送信
      // 配列に格納 
      this.childSteps.forEach(function(value,index){
        data.append('child_title[' + index + ']',value.title);
        data.append('child_time[' + index + ']',value.time);
        data.append('child_content[' + index + ']',value.content);
      });
      data.append('sum', sum); 
      
      let config = {
        headers: {
          'content-type': 'multipart/form-data',
          'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        };

      // axios通信
      // 新規登録と編集でルートを分ける
      let url = '';
      if(this.editFlg){
         url = '/step/' + this.parentStepData[0].id;
      }else{
         url = '/step';
      }
      
       axios.post(url, data, config).then(res => {
        console.log(res);
        location.href = '/mypage';
      })
      .catch(err => {
        this.errs = err.response.data.errors;
        if(err.response.status === 422){
          alert('入力内容に誤りがあります。ご確認のうえ、もう一度入力してください');
        }else{
          alert('エラーが発生しました。しばらく経ってから再度お試しください。')
        }
      });
    }
  }
}
</script>
<style>
.show-enter-active{
  transition: all .3s;
  max-height: 500px;
  overflow: hidden;
}
.show-enter{
  overflow: hidden;
  max-height: 0;
}
</style>