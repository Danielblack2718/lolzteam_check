// mixins/sweet-alert-mixin.js

import Swal from 'sweetalert2'

export default {
  methods: {
    showSuccessMessage(title,message) {
      Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        background: '#363636',
        color: 'white',
        confirmButtonColor: 'rgb(34, 142, 93)'
      })
    },
    showErrorMessage(title,message) {
      Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        background: '#363636',
        color: 'white',
        confirmButtonColor: 'rgb(239, 100, 100)'
      })
    }
  }
}
