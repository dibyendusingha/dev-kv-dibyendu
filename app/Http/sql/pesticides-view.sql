    DROP VIEW IF EXISTS pesticidesView;
    CREATE VIEW pesticidesView AS SELECT

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

        pe.id,
        pe.category_id,
        pe.user_id,
        pe.title,
        pe.description,
        pe.price,
        pe.is_negotiable,
        pe.image1,
        pe.image2,
        pe.image3,
        pe.country_id,
        pe.state_id,
        pe.district_id,
        pe.city_id,
        pe.pincode,
        pe.latlong,
        pe.is_featured,
        pe.valid_till,
        pe.ad_report,
        pe.status,
        pe.created_at,
        pe.updated_at,
        pe.reason_for_rejection,
        pe.rejected_by,
        pe.rejected_at,
        pe.approved_by,
        pe.approved_at,

        st.state_name,

        di.district_name


        FROM  pesticides  AS pe
        LEFT OUTER JOIN city  AS ct ON pe.city_id         = ct.id
        LEFT OUTER JOIN state AS st ON pe.state_id        = st.id
        LEFT OUTER JOIN district AS di ON pe.district_id  = di.id
        
        WHERE ct.district_id = pe.district_id;

