<template>
  <div class="main-layout">
    <Head />
    <SideBar />

    <div class="container-lg mt-4">
      <child />
    </div>
  </div>
</template>

<script>
import Head from '~/components/Head'
import SideBar from '~/components/SideBar'

export default {
  name: 'MainLayout',

  components: {
    Head,
    SideBar
  }
}
</script>
<style scoped>
@import url("../style.css");
</style>
