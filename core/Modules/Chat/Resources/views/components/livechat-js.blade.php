<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

<script>
    class LiveChat {
        pusher;
        channel;
        chatNotificationChannel;
        logEnable;
        appCluster;
        appKey;
        appUrl;

        constructor() {
            this.appKey ="{{env('PUSHER_APP_KEY')}}";
            this.appCluster ="{{env('PUSHER_APP_CLUSTER')}}";
            this.appUrl ="{{env('APP_URL')}}";
            this.pusher = this.createInstance();
            this.channel = null;
            this.chatNotificationChannel = null;
            this.notificationChannel = null;
        }

        createInstance(){
            this.pusher = null;
            return new Pusher(this.appKey, {
                cluster: this.appCluster,
                channelAuthorization: { endpoint: `${this.appUrl}/broadcasting/auth` }
            });
        }

        enableLog(){
            Pusher.logToConsole = true;
        }

        createChannel(client_id, freelancer_id, type) {
            if(type === 'client')
                this.channel = this.pusher.subscribe(`private-livechat-freelancer-channel.${client_id}.${freelancer_id}`);
            else
                this.channel = this.pusher.subscribe(`private-livechat-client-channel.${freelancer_id}.${client_id}`);
        }

        removeChannel(client_id, freelancer_id, type){
            if(type === 'client')
                this.channel = this.pusher.unsubscribe(`private-livechat-freelancer-channel.${client_id}.${freelancer_id}`);
            else
                this.channel = this.pusher.unsubscribe(`private-livechat-client-channel.${freelancer_id}.${client_id}`);
        }

        bindEvent(eventName, callback) {
            this.channel.bind(eventName, callback);
        }

        // private channels for new message notification 
        createChatNotificationChannel(user_id) {
                this.chatNotificationChannel = this.pusher.subscribe(`private-livechat-notification-channel.${user_id}`);
        }

        // private channels binding for  new message notification 
        bindChatNotificationEvent(eventName, callback) {
                this.chatNotificationChannel.bind(eventName, callback);
        }

        // private channels for new app notification 
        createNotificationChannel(user_id) {
                this.notificationChannel = this.pusher.subscribe(`private-app-notification-channel.${user_id}`);
        }

        // private channels binding for new app notification 
        bindNotificationEvent(eventName, callback) {
                this.notificationChannel.bind(eventName, callback);
        }
    }
</script>
