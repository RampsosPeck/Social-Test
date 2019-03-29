let user = document.head.querySelector('meta[name="user"]');

module.exports = {
    computed : {
        currentUser(){
            //if(this.isAuthenticate){
                return JSON.parse(user.content);
            //}
            //return {
            //    name : "Usuario invitado"
            //}
        },
        isAuthenticate(){
            return !! user.content;
        },
        guest(){
            return ! this.isAuthenticate();
        }
    },
};
