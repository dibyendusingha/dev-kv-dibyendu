    DROP VIEW IF EXISTS couponView;

    CREATE VIEW couponView AS SELECT

        pt.id promotion_tag_id,
        pt.name promotion_tag_name,
        pt.tag_image promotion_tag_image,

        pp.id package_table_id,
        pp.package_name,
        pp.no_of_products,
        pp.seller_tag_id,
        pp.subscription_featue_id,
        pp.subscription_boosts_id,
        pp.no_of_boots,
        pp.customer_service,
        pp.leads,
        pp.duration,
        pp.package_price,
       
        

        pc.id,
        pc.user_id,
        pc.coupon_code,
        pc.total_days,
        pc.total_days_start_day,
        pc.total_days_end_day,
        pc.buffer_days,
        pc.buffer_days_start_day,
        pc.buffer_days_end_day,
        pc.start_date,
        pc.end_date,
        pc.purchase_price,
        pc.downpayment_price,
        pc.discount,
        pc.package_id,
        pc.transaction_type,
        pc.transaction_id,
        pc.order_id,
        pc.gst,
        pc.cgst,
        pc.sgst,
        pc.igst,
        pc.invoice_no,
        pc.marketer_user_id,
        pc.status,
        pc.created_at,
        pc.updated_at
        FROM promotion_coupons  AS pc
        LEFT OUTER JOIN promotion_package  AS pp ON pc.package_id         = pp.id
        LEFT OUTER JOIN promotion_tags AS pt ON pp.seller_tag_id        = pt.id
        WHERE pc.package_id = pp.id;

