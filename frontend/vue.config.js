const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  
  transpileDependencies: true,
  devServer: {
    proxy: {
      '/public/api': {
        target: 'http://localhost', // Замените на URL вашего бэкенда
        changeOrigin: true,
      },
      '/admin': {
        target: 'http://localhost:8000', // Замените на URL вашего бэкенда
        changeOrigin: true,
      }
    },
  },
})
