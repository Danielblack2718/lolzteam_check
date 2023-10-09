<template>
    <QuillEditor :modules="modules" toolbar="full"  theme="bubble"/>
</template>
  
<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.bubble.css';
import ImageUploader from 'quill-image-uploader';
import axios from 'axios';


export default {
    components: {
        QuillEditor,
    },
    setup: () => {
        const modules = {
            name: 'imageUploader',
            module: ImageUploader,
            options: {
                upload: file => {
                    return new Promise((resolve, reject) => {
                        const formData = new FormData();
                        formData.append("image", file);
                        console.log(formData)
                        axios.post('http://localhost:80/public/api/upload-image', formData)
                            .then(res => {
                                console.log(res)
                                resolve(res.data.url);
                            })
                            .catch(err => {
                                reject("Upload failed");
                                console.error("Error:", err)
                            })
                    })
                }
            }
        }
        return {
            modules
        }
    }
}

</script>