<template>
  <div class="p-form__container">
            <div class="p-form">
              <h2 class="p-form__title">STEP:{{ (index < 9) ? '0' + (index + 1) : index +1 }}</h2>
              <!-- 子ステップタイトル -->
               <p class="p-form__errmsg" v-if="errs['child_title.'+index]">
                {{ errs['child_title.'+index][0]}}
               </p>
               <p class="p-form__errmsg" v-if="title.length > 20">
                  20文字以内で入力してください
               </p>
              <div class="p-form__content">
                <span class="p-form__name">タイトル</span>
                <input v-model="title" type="text" class="p-form__input--text" :class="errs['child_title.'+index] || title.length > 20 ? 'p-form__input--err': '' ">
              </div>

              <!-- 子ステップ目安時間 -->
              <p class="p-form__errmsg" v-if="errs['child_time.'+index]">
                {{ errs['child_time.'+index][0]}}
              </p>
              <div class="p-form__content">
                <span class="p-form__name">目安時間</span>
                <select v-model="time" class="p-form__select" name="" id="" :class="errs['child_time.'+index] ? 'p-form__input--err': '' ">
                  <option v-for="time in times" :key="time.min" :value="time.min">{{ time.value }}</option>
                </select>
              </div>

              <!-- 子ステップ内容 -->
              <p class="p-form__errmsg" v-if="errs['child_content.'+index]">
                {{ errs['child_content.'+index][0]}}
              </p>
              <p class="p-form__errmsg" v-if="content.length > 191">
                191文字以内で入力してください
              </p>
              <div class="p-form__content" style="margin-bottom:0">
                <span class="p-form__name">STEP{{ (index < 9) ? '0' + (index + 1) : index +1 }}内容</span>
                <textarea v-model="content" name="" id="" class="p-form__textarea" :class="errs['child_content.'+index] || content.length > 191 ? 'p-form__input--err': '' "></textarea>
              </div>
              <p class="p-form__counter">※191文字以内で入力してください<br>{{content.length}} / 191</p>
          </div>
        </div>
</template>
<script>
export default {
  props: ['value', 'index','errs'],
  data: function(){
    return {
      id: '',
      title: '',
      content: '',
      time: '',
      times:[
        { min: '', value: '選択してください' },
        { min: 30, value: '30分' },
        { min: 60, value: '1時間' },
        { min: 90, value: '1時間半' },
        { min: 120, value: '2時間' },
        { min: 150, value: '2時間半' },
        { min: 180, value: '3時間' },
        { min: 210, value: '3時間半' },
        { min: 240, value: '4時間' },
        { min: 270, value: '4時間半' },
        { min: 300, value: '5時間' },
      ]
    }
  },
  //コンポーネントが読み込まれたタイミングで、親から渡された値でデータを初期化する
  mounted: function(){
    this.id  = this.value.id;
    this.title = this.value.title;
    this.content = this.value.content;
    this.time = this.value.time; 
    
  },
  // inputメソッド発火で親データを更新する
  updated: function(){
    this.$emit('input',{
      id: this.id,
      title:  this.title,
      content: this.content,
      time: this.time,
    });
  }
}
</script>