<template>
  <div class="row">
      <div class="loader-box" v-if="!$store.getters.ready">
        <i class="fa fa-spinner fa-spin loading-box"></i>
      </div>
  </div>
</template>