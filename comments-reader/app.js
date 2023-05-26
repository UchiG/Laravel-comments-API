const express = require('express');
const axios = require('axios');

const app = express();

app.get('/comments', (req, res) => {
  // Make a GET request to the API endpoint
  axios.get(`${process.env.APP_URL}/comments`)
    .then(response => {
      // Handle the response
      const comments = response.data;
      // Pass the comments data to the appropriate view or return as a response
      res.json(comments);
    })
    .catch(error => {
      // Handle the error
      console.error('Error:', error.message);
      res.status(500).json({ error: 'An error occurred' });
    });
});

const port = 3000; // or any other preferred port number
app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
