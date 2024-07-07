    DROP VIEW IF EXISTS seedView;

    CREATE VIEW seedView AS SELECT

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

        se.id,
        se.category_id,
        se.user_id,
        se.title,
        se.description,
        se.price,
        se.is_negotiable,
        se.image1,
        se.image2,
        se.image3,
        se.country_id,
        se.state_id,
        se.district_id,
        se.city_id,
        se.pincode,
        se.latlong,
        se.is_featured,
        se.valid_till,
        se.ad_report,
        se.status,
        se.created_at,
        se.updated_at,
        se.reason_for_rejection,
        se.rejected_by,
        se.rejected_at,
        se.approved_by,
        se.approved_at,

        st.state_name,

        di.district_name


        FROM  seeds  AS se
        LEFT OUTER JOIN city  AS ct ON se.city_id         = ct.id
        LEFT OUTER JOIN state AS st ON se.state_id        = st.id
        LEFT OUTER JOIN district AS di ON se.district_id  = di.id

        WHERE ct.district_id = se.district_id;

