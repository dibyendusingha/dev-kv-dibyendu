DROP VIEW IF EXISTS iffcoDealerView;
CREATE VIEW iffcoDealerView AS SELECT

            ct.id cityPrimaryId,
            ct.pincode cityPin,
            ct.city_name,
            ct.region_id,
            ct.country_id cityCountryId,
            ct.state_id cityStateId,
            ct.district_id cityDistrict,
            ct.latitude,
            ct.longitude,

            us.id,
            us.name,
            us.company_name,
            us.mobile,
            us.email,
            us.address,
            us.country_id,
            us.state_id,
            us.district_id,
            us.city_id,
            us.zipcode,
            us.photo,
            us.status,

            di.district_name,
           
            st.state_name


            FROM  user  AS us

            LEFT OUTER JOIN city      AS ct ON us.city_id      = ct.id
            LEFT OUTER JOIN district  AS di ON us.district_id  = di.id
            LEFT OUTER JOIN  state    AS st ON us.state_id     = st.id;


