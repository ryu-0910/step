<template>
   <ul class="p-side__nav">
     <a :href="/step/ + parentStep.id +'/' + childSteps.id" class="p-side__navlink">
       <li class="p-side__navitem">
       <span class="p-side__navtitle">{{childSteps.num}}</span><p class="p-side__navtext">{{childSteps.title}}</p>
     </li>
     </a>
   </ul>
</template>
<script>
export default {
  props:['parentStep','childSteps']
}
</script>