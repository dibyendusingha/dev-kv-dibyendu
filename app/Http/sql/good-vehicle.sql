    DROP VIEW IF EXISTS goodVehicleView;
    CREATE VIEW goodVehicleView AS SELECT

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


        gv.id,
        gv.category_id,
        gv.user_id,
        gv.set,
        gv.type,
        gv.brand_id,
        gv.model_id,
        gv.year_of_purchase,
        gv.title,
        gv.rc_available,
        gv.noc_available,
        gv.registration_no,
        gv.description,
        gv.left_image,
        gv.right_image,
        gv.front_image,
        gv.back_image,
        gv.meter_image,
        gv.tyre_image,
        gv.price,
        gv.rent_type,
        gv.is_negotiable,
        gv.pincode,
        gv.country_id,
        gv.state_id,
        gv.district_id,
        gv.city_id,
        gv.latlong,
        gv.ad_report,
        gv.status,
        gv.created_at ,
        gv.updated_at,
        gv.reason_for_rejection,
        gv.rejected_by,
        gv.rejected_at,
        gv.approved_by,
        gv.approved_at,

        st.state_name,

        di.district_name,

        br.name brand_name,

        mo.model_name

        FROM   goods_vehicle  AS gv
        LEFT OUTER JOIN city  AS ct ON gv.city_id        = ct.id
        LEFT OUTER JOIN state AS st ON gv.state_id       = st.id
        LEFT OUTER JOIN district AS di ON gv.district_id = di.id
        LEFT OUTER JOIN brand AS br ON gv.brand_id       = br.id
        LEFT OUTER JOIN model AS mo ON gv.model_id       = mo.id
        
        WHERE ct.district_id = gv.district_id;

