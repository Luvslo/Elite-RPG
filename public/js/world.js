

axios.get('/maps').then(response => {
    image.src = response.data;
});
