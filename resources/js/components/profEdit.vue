<template>
  <div class="u-bg--default">
      <div class="c-container">
        <div class="p-form">
          <h2 class="p-form__title">プロフィール編集</h2>
          <!-- プロフィール画像 -->
            <p class="p-form__errmsg" v-if="errs.img">
                {{errs.img[0]}}
            </p>

          <div class="p-form__content">
            <span class="p-form__name">プロフィール画像</span>
            <div class="p-profile__avater">
              ドラッグ＆ドロップ
              <input type="file" id="img" name="img" class="p-profile__avater--input" accept="image/*" :class="errs.img ? 'p-form__input--err': '' " @change="onFileChange">
              <img :src="showImg" alt="" class="p-profile__avater--img">
            </div>
          </div>

          <!-- ユーザー名 -->
          <p class="p-form__errmsg" v-if="errs.name">
                {{errs.name[0]}}
          </p>
          <p class="p-form__errmsg" v-if="name.length > 20">
                20文字以内で入力してください
          </p>
          
          <div class="p-form__content">
            <span class="p-form__name">ユーザー名</span>
            <input v-model="name" type="text" id="name" name="name"  class="p-form__input--text" :class="errs.name || name.length > 20? 'p-form__input--err': '' " >
          </div>
          
          <!-- Email -->
          <p class="p-form__errmsg" v-if="errs.email">
                {{errs.email[0]}}
          </p>

          <div class="p-form__content">
            <span class="p-form__name">email</span>
            <input type="email" id="email" name="email" v-model="email" class="p-form__input--text" :class="errs.email ? 'p-form__input--err': '' " required autocomplete="email">
          </div>

          <!-- 自己紹介 -->
          <p class="p-form__errmsg" v-if="errs.intro">
                {{errs.intro[0]}}
          </p>
          <p class="p-form__errmsg" v-if="intro.length > 191">
                191文字以内で入力してください
          </p>

          <div class="p-form__content" style="margin-bottom:0">
            <span class="p-form__name">自己紹介</span>
            <textarea name="intro" id="intro" v-model="intro" class="p-form__textarea" :class="errs.intro || intro.length > 191 ? 'p-form__input--err': '' "></textarea>
          </div>
          <p class="p-form__counter">※191文字以内で入力してください<br>{{intro.length}} / 191</p>
        
          <div class="c-btn c-btn__container--right">
            <button class="c-btn__btn--default" @click="onSubmit" >保存</button>
          </div>
        </div>
      </div>
    </div>
</template>
<script>
export default {
  props: ['user'],
  data: function(){
    return{
      showImg: this.user.img ? '/storage/img/' + this.user.img : '/img/no-img.png',
      name: this.user.name ? this.user.name : '',
      email: this.user.email ? this.user.email : '',
      img: this.user.img ? this.user.img : '',
      intro: this.user.intro ? this.user.intro : '',
      errs:{
        name: '',
        img: '',
        email: '',
        intro: '',
      }
    }
  },
  
  methods: {
    //画像プレビュー
    onFileChange : function(e){
      //画像データの読み込み
      let files  = e.target.files;
      if(files.length > 0){ //ファイルが選択されたかチェック
        const file = files[0];
        const reader = new FileReader(); 
        reader.onload = e => {
          this.showImg = e.target.result;
      };
      reader.readAsDataURL(file);
      }
      this.img = files[0];
    },

    //プロフィール編集
    onSubmit : function(){
      //フォームへの入力データを追加
      let data = new FormData();
      typeof this.img === 'string' ? false : data.append('img', this.img);  //画像更新しない(dataがアップロードパス)時はimageバリデーションに引っかかるため更新しない
      data.append('name', this.name);
      data.append('email', this.email);
      data.append('intro', this.intro);
      let config = {
        headers: {
          'content-type': 'multipart/form-data',
          'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        };

      //axios通信
      axios.post('/prof', data, config).then(res => {
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
        console.log(err.response.data.errors);
      });
    }
  }
}
</script>
