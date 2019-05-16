var options1 = {
    "key": "YOUR_KEY_ID",
    "amount": "255000", // 2000 paise = INR 20
    "name": "StarClinch",
    "description": "Power Up Subscription",
    "image": "/favicon.png",
    "handler": function (response){
        alert(response.razorpay_payment_id);
    },
    "prefill": {
        
    },
    "notes": {
        "address": ""
    },
    "theme": {
        "color": "#F37254"
    }
};
var options2 = {
    "key": "YOUR_KEY_ID",
    "amount": "650000", // 2000 paise = INR 20
    "name": "StarClinch",
    "description": "Get Discovered Subscription",
    "image": "/favicon.png",
    "handler": function (response){
        alert(response.razorpay_payment_id);
    },
    "prefill": {
        
    },
    "notes": {
        "address": ""
    },
    "theme": {
        "color": "#F37254"
    }
};
var options3 = {
    "key": "YOUR_KEY_ID",
    "amount": "3250000", // 2000 paise = INR 20
    "name": "StarClinch",
    "description": "Instant Gigs Subscription",
    "image": "/favicon.png",
    "handler": function (response){
        alert(response.razorpay_payment_id);
    },
    "prefill": {
        
    },
    "notes": {
        "address": ""
    },
    "theme": {
        "color": "#F37254"
    }
};

var rzp1 = new Razorpay(options1);
document.getElementById('rzp-power-up').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
var rzp2 = new Razorpay(options2);
document.getElementById('rzp-get-discovered').onclick = function(e){
    rzp2.open();
    e.preventDefault();
}
var rzp3 = new Razorpay(options3);
document.getElementById('rzp-instant-gigs').onclick = function(e){
    rzp3.open();
    e.preventDefault();
}
