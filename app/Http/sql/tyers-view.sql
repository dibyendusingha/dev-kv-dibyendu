    DROP VIEW IF EXISTS tyresView;

    CREATE VIEW tyresView AS SELECT

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

        tr.id,
        tr.category_id,
        tr.user_id,
        tr.type,
        tr.brand_id,
        tr.model_id,
        tr.year_of_purchase,
        tr.title,
        tr.position,
        tr.price,
        tr.description,
        tr.image1,
        tr.image2,
        tr.image3,
        tr.is_negotiable,
        tr.country_id,
        tr.state_id,
        tr.district_id,
        tr.city_id,
        tr.pincode,
        tr.latlong,
        tr.is_featured,
        tr.valid_till,
        tr.ad_report,
        tr.status,
        tr.created_at,
        tr.updated_at,
        tr.reason_for_rejection,
        tr.rejected_by,
        tr.rejected_at,
        tr.approved_by,
        tr.approved_at,

        st.state_name,

        di.district_name,

        br.name brand_name,

        mo.model_name


        FROM  tyres  AS tr
        LEFT OUTER JOIN city  AS ct ON tr.city_id          = ct.id
        LEFT OUTER JOIN state AS st ON tr.state_id        = st.id
        LEFT OUTER JOIN district AS di ON tr.district_id  = di.id
        LEFT OUTER JOIN brand AS br ON tr.brand_id        = br.id
        LEFT OUTER JOIN model AS mo ON tr.model_id        = mo.id
        
        WHERE ct.district_id = tr.district_id;

