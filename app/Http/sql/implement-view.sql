    DROP VIEW IF EXISTS implementView;

    CREATE VIEW implementView AS SELECT

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

        im.id,
        im.category_id,
        im.user_id,
        im.set,
        im.type,
        im.brand_id,
        im.model_id,
        im.year_of_purchase,
        im.title,
        im.left_image,
        im.right_image,
        im.front_image,
        im.back_image,
        im.spec_id,
        im.description,
        im.price,
        im.rent_type,
        im.is_negotiable,
        im.country_id,
        im.state_id,
        im.district_id,
        im.city_id,
        im.pincode,
        im.latlong,
        im.is_featured,
        im.valid_till,
        im.ad_report,
        im.status,
        im.created_at,
        im.updated_at,
        im.reason_for_rejection,
        im.rejected_by,
        im.approved_by,
        im.approved_at,

        st.state_name,

        di.district_name,

        br.name brand_name,

        mo.model_name


        FROM  implements  AS im
        LEFT OUTER JOIN city  AS ct ON im.city_id         = ct.id
        LEFT OUTER JOIN state AS st ON im.state_id        = st.id
        LEFT OUTER JOIN district AS di ON im.district_id  = di.id
        LEFT OUTER JOIN brand AS br ON im.brand_id        = br.id
        LEFT OUTER JOIN model AS mo ON im.model_id        = mo.id
        
        WHERE ct.district_id = im.district_id;

