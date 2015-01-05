var client = new Keen({
    
  });

var keen = {
    client: null,
    
    init: function(pid) {
        keen.client = new Keen({
            projectId: pid,   // String (required)
            writeKey: "f670588f26620919ee059ebd581e129d4a8324c70ed7970e7a23a5a29cf1822d6fe1e24076d54b6343feec427274f0573764f4565292e9cc3ed0076f4a6ad5bf01cd6e0ea209135308a44102426047f834732a592a52c57a76444e312315d93ecfbbc9522893144c44299b60d8c19c20",     // String (required for sending data)
            readKey: "e105b68fb3305922465bec640b6e9cc8e964ebe868093aa8e58fa171f5b9d4daab760fc5e8f80a54768b78ef5404546ab48d824ceb30bf52f0bc91045b2f72200d81ac7b6a4092be3a036a34e2c633f12e901a47b17149eed9fb5e517861c51b19ad91842544681fd70bc371e12e4ad9",       // String (required for querying data)
        })
    },
    
    registerEvent: function(type,data) {
        keen.client.addEvent(type,data);
    }
}