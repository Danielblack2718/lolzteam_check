<template>
    <MHeader title="Статья"></MHeader>
    <main>
        <MPost :id="postId"></MPost>
    </main>
</template>
  
<script>
import MPost from './Post/Post.vue';
import MHeader from './Header.vue';

export default {
    name: 'App',
    components: {
        MPost,
        MHeader,
        
    },
    props: {
        admin: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            postId: this.$route.params.id
        };
    }

}
</script>