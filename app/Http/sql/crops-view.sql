    DROP VIEW IF EXISTS cropsView;

    CREATE VIEW cropsView AS SELECT

        ct.id city_db_id,
        ct.pincode city_pincode,
        ct.city_name,
        ct.region_id,
        ct.country_id city_country_id,
        ct.state_id city_state_id,
        ct.district_id city_district_id,
        ct.latitude,
        ct.longitude,
        ct.status city_status,

        cs.id,
        cs.category_id,
        cs.crops_category_id,
        cs.user_id,
        cs.title,
        cs.description,
        cs.price,
        cs.type,
        cs.quantity,
        cs.expiry_date,
        cs.is_negotiable,
        cs.image1,
        cs.image2,
        cs.image3,
        cs.country_id,
        cs.state_id,
        cs.district_id,
        cs.city_id,
        cs.pincode,
        cs.latlong,
        cs.is_featured,
        cs.valid_till,
        cs.ad_report,
        cs.status,
        cs.created_at,
        cs.updated_at,
        cs.reason_for_rejection,
        cs.rejected_by,
        cs.rejected_at,
        cs.approved_by,
        cs.approved_at,

        st.state_name,

        di.district_name


        FROM   crops  AS cs
        LEFT OUTER JOIN city  AS ct ON cs.city_id          = ct.id
        LEFT OUTER JOIN state AS st ON cs.state_id         = st.id
        LEFT OUTER JOIN district AS di ON cs.district_id   = di.id
        
        WHERE ct.district_id = cs.district_id;

