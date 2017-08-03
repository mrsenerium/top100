(function(window){
    //I recommend this
    'use strict';
    function define_storagehelper(){
        //https://gist.github.com/porkeypop/1096149
        var storage = {
            save : function(key, jsonData, expirationMin){
                if (typeof (Storage) == "undefined"){return false;}
                var expirationMS = expirationMin * 60 * 1000;
                var record = {value: JSON.stringify(jsonData), timestamp: new Date().getTime() + expirationMS}
                localStorage.setItem(key, JSON.stringify(record));
                return jsonData;
            },
            load : function(key){
                if (typeof (Storage) == "undefined"){return false;}
                var record = JSON.parse(localStorage.getItem(key));
                if (!record){return false;}
                return (new Date().getTime() < record.timestamp && JSON.parse(record.value));
            }
        }
        return storage;
    }
    //define globally if it doesn't already exist
    if(typeof(StorageHelper) === 'undefined'){
        window.StorageHelper = define_storagehelper();
    }
    else{
        console.log("StorageHelper already defined.");
    }
})(window);
