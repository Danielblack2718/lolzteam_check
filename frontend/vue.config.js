const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: {
    proxy: {
      '/api': {
        target: 'http://localhost:8080', // Замените на URL вашего бэкенда
        changeOrigin: true,
        pathRewrite: { '^/api': '' },
      },
      '/storage': {
        target: 'http://localhost:8080/storage',
        changeOrigin: true,
      },
    },
  },
})
