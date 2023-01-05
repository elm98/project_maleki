let server = require('http').Server();
let io = require('socket.io')(server);
let Redis = require('ioredis');
let redis1 = new Redis();
let redis2 = new Redis();

redis1.subscribe('test');
redisON(redis);

redis2.subscribe('general');
redisON(redis2);

// -- Redis On Subscribe Channel
function redisON(redis){
    redis.on('message',function (channel,message) {
        if(IsJsonString(message)){
            let $data = JSON.parse(message);
            io.emit(channel + ':'+$data.event,$data.data);
            console.log(channel);
            console.log($data);
        }else{
            console.log('channel '+channel+' : Wrong Data Json');
        }
    });
}

// -- Set Server Listen Port
server.listen(3000,function () {
    console.log('server is listening on http://localhost:3000');
});

// -- Is Json Valid
function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


