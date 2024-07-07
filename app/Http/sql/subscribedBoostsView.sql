    DROP VIEW IF EXISTS subscribedBootsView;

    CREATE VIEW subscribedBootsView AS SELECT

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

        fa.id,
        fa.category_id,
        fa.user_id,
        fa.title,
        fa.description,
        fa.price,
        fa.is_negotiable,
        fa.image1,
        fa.image2,
        fa.image3,
        fa.country_id,
        fa.state_id,
        fa.district_id,
        fa.city_id,
        fa.pincode,
        fa.latlong,
        fa.is_featured,
        fa.valid_till,
        fa.ad_report,
        fa.status,
        fa.created_at,
        fa.updated_at,
        fa.reason_for_rejection,
        fa.rejected_by,
        fa.rejected_at,
        fa.approved_by,
        fa.approved_at,

        st.state_name,

        di.district_name


        FROM   fertilizers  AS fa
        LEFT OUTER JOIN city  AS ct ON fa.city_id          = ct.id
        LEFT OUTER JOIN state AS st ON fa.state_id         = st.id
        LEFT OUTER JOIN district AS di ON fa.district_id   = di.id
        
        WHERE ct.district_id = fa.district_id;

