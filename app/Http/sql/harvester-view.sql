    DROP VIEW IF EXISTS harvesterView;
    CREATE VIEW harvesterView AS SELECT

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


        har.id,
        har.category_id,
        har.user_id,
        har.set,
        har.type,
        har.brand_id,
        har.model_id,
        har.year_of_purchase,
        har.title,
        har.crop_type,
        har.cutting_with,
        har.power_source,
        har.spec_id,
        har.left_image,
        har.right_image,
        har.front_image,
        har.back_image,
        har.description,
        har.price,
        har.rent_type,
        har.is_negotiable,
        har.country_id,
        har.state_id,
        har.district_id,
        har.city_id,
        har.pincode,
        har.latlong,
        har.is_featured,
        har.valid_till,
        har.ad_report,
        har.status,
        har.created_at,
        har.updated_at,
        har.reason_for_rejection,
        har.rejected_by,
        har.rejected_at,
        har.approved_by,
        har.approved_at,

        st.state_name,

        di.district_name,

        br.name brand_name,

        mo.model_name


        FROM  harvester  AS har
        LEFT OUTER JOIN city  AS ct ON har.city_id        = ct.id
        LEFT OUTER JOIN state AS st ON har.state_id       = st.id
        LEFT OUTER JOIN district AS di ON har.district_id = di.id
        LEFT OUTER JOIN brand AS br ON har.brand_id       = br.id
        LEFT OUTER JOIN model AS mo ON har.model_id       = mo.id
        
        WHERE ct.district_id = har.district_id;

