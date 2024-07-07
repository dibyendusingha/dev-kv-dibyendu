    DROP VIEW IF EXISTS cropsSubscribedView;

    CREATE VIEW cropsSubscribedView AS SELECT
       
        csbs.id subscribed_id,
        csbs.subscription_id,
        csbs.user_id,
        csbs.category_id,
        csbs.start_date,
        csbs.end_date,
        csbs.purchased_price,
        csbs.transaction_id,
        csbs.order_id,
        csbs.gst,
        csbs.sgst,
        csbs.cgst,
        csbs.igst,
        csbs.invoice_no,
        csbs.downpayment,
        csbs.discount,
        csbs.created_at crops_subscribed_created_at,
        csbs.status crops_subscribed_status,

        cs.crop_subscriptions_name,

        csf.days subscription_days,
        csf.price subscription_price,

        u.name username,
        u.user_type_id ,
        u.mobile user_mobile,
        u.zipcode user_zipcode,
        u.verify_tag verify_tag,
        u.crops_verify_tag crops_verify_tag
        
        FROM crops_subscribeds  AS csbs
        LEFT OUTER JOIN crop_subscriptions AS cs ON csbs.subscription_id  = cs.id
        LEFT OUTER JOIN crop_subscription_features  AS csf ON cs.id  = csf.crops_subscription_id
        LEFT OUTER JOIN user  AS u ON csbs.user_id = u.id
    

