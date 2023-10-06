<template>
    <div v-if="adminKey">
        <MAdminPosts></MAdminPosts>
    </div>
    <div v-else>
        <p>Вы не авторизованы для доступа к этой странице.</p>
    </div>
</template>
  
<script>
import MAdminPosts from './AdminPosts.vue';

export default {
    name: 'MAdminPanel',
    components: {
        MAdminPosts
    },
    data() {
        return {
            adminKey: this.$cookies.get("adminKey")
        };
    }
};
</script>
  