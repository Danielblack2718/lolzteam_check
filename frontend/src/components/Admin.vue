
<template>
    <MAdminLogin v-if="!adminKey"></MAdminLogin>
    <MAdminPanel v-else></MAdminPanel>
</template>

<script>
import MAdminLogin from './Admin/AdminLogin.vue';
import MAdminPanel from './Admin/Admin.vue';
export default {
    name: 'MAdmin',
    components: {
        MAdminLogin,
        MAdminPanel
    },
    data() {
        return {
            adminKey: this.$cookies.get("adminKey")
        };
    }
}
</script>