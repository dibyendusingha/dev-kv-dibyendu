    DROP VIEW IF EXISTS tractorView;

    CREATE VIEW tractorView AS SELECT

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

        tac.id,
        tac.category_id,
        tac.user_id,
        tac.set,
        tac.type,
        tac.brand_id,
        tac.model_id,
        tac.year_of_purchase,
        tac.title,
        tac.rc_available,
        tac.noc_available,
        tac.registration_no,
        tac.description,
        tac.left_image,
        tac.right_image,
        tac.front_image,
        tac.back_image,
        tac.meter_image,
        tac.tyre_image,
        tac.price,
        tac.rent_type,
        tac.is_negotiable,
        tac.country_id,
        tac.state_id,
        tac.district_id,
        tac.city_id,
        tac.pincode,
        tac.latlong tractor_latlong,
        tac.ad_report,
        tac.status,
        tac.created_at,
        tac.updated_at,
        tac.reason_for_rejection,
        tac.rejected_by,
        tac.rejected_at,
        tac.approved_by,
        tac.approved_at,

        st.state_name,

        di.district_name,

        br.name brand_name,

        mo.model_name

    
       
       
        WHERE ct.district_id = tac.district_id;
