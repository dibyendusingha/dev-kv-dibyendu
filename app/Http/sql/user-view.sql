    DROP VIEW IF EXISTS userView;

    CREATE VIEW userView AS SELECT

        ct.id city_db_id,
        ct.pincode city_pincode,
        ct.city_name,
        ct.country_id city_country_id,
        ct.state_id city_state_id,
        ct.district_id city_district_id,
        ct.latitude,
        ct.longitude,
        ct.status city_status,

        u.id,
        u.user_type_id ,
        u.role_id,
        u.name,
        u.company_name,
        u.gst_no,
        u.mobile,
        u.email,
        u.facebook_id,
        u.google_id,
        u.gender,
        u.address,
        u.country_id,
        u.state_id,
        u.district_id,
        u.city_id,
        u.zipcode,
        u.lat,
        u.long,
        u.photo,
        u.dob,
        u.latlong,
        u.referral_code,
        u.login_via,
        u.phone_verified,
        u.email_verified,
        u.whatsapp_optin,
        u.newsletter_optin,
        u.sms_optin,
        u.marketing_optin,
        u.kyc,
        u.ip_address,
        u.device_id,
        u.firebase_token,
        u.user_source,
        u.reference_id,
        u.converted_seller,
        u.paid_or_free,
        u.token,
        u.status,
        u.profile_update,
        u.email_newslatter,
        u.whatsapp_notification,
        u.promotin,
        u.marketing_communication,
        u.social_media_promotion,
        u.last_activity,
        u.last_login,
        u.created_at,
        u.updated_at,
        u.user_disabled_date,
        u.lamguage,
        u.company_id,
        u.notification_counter,
        u.user_type,

        st.state_name,

        di.district_name


        FROM   user  AS u
        LEFT OUTER JOIN city  AS ct ON u.city_id          = ct.id
        LEFT OUTER JOIN state AS st ON u.state_id         = st.id
        LEFT OUTER JOIN district AS di ON u.district_id   = di.id;
        
        -- WHERE ct.district_id = u.district_id;

