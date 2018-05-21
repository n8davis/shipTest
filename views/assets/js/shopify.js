ShopifyApp.init({
    apiKey: key, // add your own app api key
    shopOrigin: shop, // add the client shop here
    debug: false,
    forceRedirect: true
});

ShopifyApp.Bar.initialize({
    buttons: {
        // primary: {
        //     label: "Shipping Zones",
        //     href : '/'
        // },
        // secondary: [
        //     { label: "Help", callback: function(){ alert('help'); } },
        //     { label: "More",
        //         type: "dropdown",
        //         links: [
        //             { label: "Update", href: "/update", target: "app" },
        //             { label: "Delete", callback: function(){ alert("destroy") } }
        //         ]
        //     },
        //     { label: "Preview", href: "http://my-app.com/preview_url", target: "new" }
        // ]
    },
    title: title,
    icon: ''
});