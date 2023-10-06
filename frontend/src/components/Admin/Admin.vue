<template>
    <div v-if="adminKey">
        <MHeader title="Административная панель"></MHeader>
        <MAdminPanel></MAdminPanel>
    </div>
    <div v-else>
        <p>Вы не авторизованы для доступа к этой странице.</p>
    </div>
</template>
  
<script>
import MHeader from '../Header.vue';
import MAdminPanel from './AdminPanel.vue';

export default {
    name: 'MAdmin',
    components: {
        MHeader,
        MAdminPanel
       
    },
    data() {
        return {
            adminKey: this.$cookies.get("adminKey")
        };
    }
};
</script>
  