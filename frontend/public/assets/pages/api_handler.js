

const axios = require('axios');

console.log(" It's working")
async function getUser() {
    console.log("async working")
try {
const response = await axios.get('http://127.0.0.1:8001/api/user');
console.log(response);
console.log(" no error")
} catch (error) {
console.error(error);
console.log("Error")

}
}