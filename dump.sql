--
-- PostgreSQL database dump
--

-- Dumped from database version 10.8 (Ubuntu 10.8-0ubuntu0.18.04.1)
-- Dumped by pg_dump version 10.8 (Ubuntu 10.8-0ubuntu0.18.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.roles (id, name, guard_name, created_at, updated_at) VALUES (1, 'Administrador', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');
INSERT INTO public.roles (id, name, guard_name, created_at, updated_at) VALUES (2, 'Formulario 1', 'web', '2019-06-05 13:42:52', '2019-06-05 13:42:52');
INSERT INTO public.roles (id, name, guard_name, created_at, updated_at) VALUES (3, 'Instituto para el Envejecimiento Digno', 'web', '2019-06-05 14:12:21', '2019-06-05 14:12:21');


--
-- Data for Name: item_rols; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.item_rols (id, rol_id, item, parent_id, editable, "order", created_at, updated_at, deleted_at) VALUES (1, 2, 'ASCII', NULL, false, 0, '2019-06-05 13:43:57', '2019-06-05 13:43:57', NULL);
INSERT INTO public.item_rols (id, rol_id, item, parent_id, editable, "order", created_at, updated_at, deleted_at) VALUES (3, 2, 'Hombres', 2, true, 2, '2019-06-05 13:44:44', '2019-06-05 13:44:44', NULL);
INSERT INTO public.item_rols (id, rol_id, item, parent_id, editable, "order", created_at, updated_at, deleted_at) VALUES (4, 2, 'HogarCDMX', NULL, false, 3, NULL, NULL, NULL);
INSERT INTO public.item_rols (id, rol_id, item, parent_id, editable, "order", created_at, updated_at, deleted_at) VALUES (2, 2, 'Atzcapotzalco', 1, true, 1, '2019-06-05 13:44:24', '2019-06-05 13:44:24', NULL);
INSERT INTO public.item_rols (id, rol_id, item, parent_id, editable, "order", created_at, updated_at, deleted_at) VALUES (5, 2, 'Ingresos', 4, true, 1, NULL, NULL, NULL);
INSERT INTO public.item_rols (id, rol_id, item, parent_id, editable, "order", created_at, updated_at, deleted_at) VALUES (6, 3, 'Acciones a Realizar', NULL, false, 0, NULL, NULL, NULL);
INSERT INTO public.item_rols (id, rol_id, item, parent_id, editable, "order", created_at, updated_at, deleted_at) VALUES (7, 3, 'Visitas Médicas (SALUD EN TU VIDA)', 6, true, 1, NULL, NULL, NULL);
INSERT INTO public.item_rols (id, rol_id, item, parent_id, editable, "order", created_at, updated_at, deleted_at) VALUES (9, 3, 'Atención brindada Análisis', 6, true, 2, NULL, NULL, NULL);


--
-- Data for Name: reports; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: item_value_reports; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: logs; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.migrations (id, migration, batch) VALUES (62, '2014_10_12_000000_create_users_table', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (63, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (64, '2019_02_27_111710_create_logs_table', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (65, '2019_04_23_131733_create_permission_tables', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (66, '2019_06_04_172918_create_item_rols_table', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (67, '2019_06_04_173023_create_rol_structure_items_table', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (68, '2019_06_04_173043_create_reports_table', 1);
INSERT INTO public.migrations (id, migration, batch) VALUES (69, '2019_06_04_173128_create_item_value_reports_table', 1);


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (1, 'create_user', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (2, 'delete_user', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (3, 'edit_user', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (4, 'index_user', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (5, 'create_roles', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (6, 'delete_roles', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (7, 'edit_roles', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (8, 'index_roles', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');
INSERT INTO public.permissions (id, name, guard_name, created_at, updated_at) VALUES (9, 'show_roles', 'web', '2019-06-05 13:39:00', '2019-06-05 13:39:00');


--
-- Data for Name: model_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: model_has_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.model_has_roles (role_id, model_type, model_id) VALUES (1, 'App\User', 1);
INSERT INTO public.model_has_roles (role_id, model_type, model_id) VALUES (2, 'App\User', 2);
INSERT INTO public.model_has_roles (role_id, model_type, model_id) VALUES (3, 'App\User', 3);


--
-- Data for Name: password_resets; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: rol_structure_items; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.rol_structure_items (id, item_rol_id, columns, "order", created_at, updated_at, deleted_at) VALUES (1, 1, 'Alimentación', 0, '2019-06-05 13:46:47', '2019-06-05 13:46:47', NULL);
INSERT INTO public.rol_structure_items (id, item_rol_id, columns, "order", created_at, updated_at, deleted_at) VALUES (2, 1, 'Atenciones Médicas', 1, NULL, NULL, NULL);
INSERT INTO public.rol_structure_items (id, item_rol_id, columns, "order", created_at, updated_at, deleted_at) VALUES (3, 1, 'Pernocta', 2, NULL, NULL, NULL);
INSERT INTO public.rol_structure_items (id, item_rol_id, columns, "order", created_at, updated_at, deleted_at) VALUES (4, 1, 'Actividades Recreativas', 3, NULL, NULL, NULL);
INSERT INTO public.rol_structure_items (id, item_rol_id, columns, "order", created_at, updated_at, deleted_at) VALUES (5, 4, 'Raciones', 0, NULL, NULL, NULL);
INSERT INTO public.rol_structure_items (id, item_rol_id, columns, "order", created_at, updated_at, deleted_at) VALUES (6, 4, 'Atenciones Médicas', 1, NULL, NULL, NULL);
INSERT INTO public.rol_structure_items (id, item_rol_id, columns, "order", created_at, updated_at, deleted_at) VALUES (7, 4, 'Personas en Enfermería', 2, NULL, NULL, NULL);
INSERT INTO public.rol_structure_items (id, item_rol_id, columns, "order", created_at, updated_at, deleted_at) VALUES (9, 6, 'Cantidad', 0, NULL, NULL, NULL);


--
-- Data for Name: role_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.role_has_permissions (permission_id, role_id) VALUES (1, 1);
INSERT INTO public.role_has_permissions (permission_id, role_id) VALUES (2, 1);
INSERT INTO public.role_has_permissions (permission_id, role_id) VALUES (3, 1);
INSERT INTO public.role_has_permissions (permission_id, role_id) VALUES (4, 1);
INSERT INTO public.role_has_permissions (permission_id, role_id) VALUES (5, 1);
INSERT INTO public.role_has_permissions (permission_id, role_id) VALUES (6, 1);
INSERT INTO public.role_has_permissions (permission_id, role_id) VALUES (7, 1);
INSERT INTO public.role_has_permissions (permission_id, role_id) VALUES (8, 1);
INSERT INTO public.role_has_permissions (permission_id, role_id) VALUES (9, 1);


--
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.users (id, name, paterno, materno, email, email_verified_at, password, remember_token, created_by, active, confirmed, created_at, updated_at) VALUES (2, 'Alberto Rios Cruz', 'Cruz', NULL, 'cruzarios@gmail.com', NULL, '$2y$10$BfpJ9U36uqU2r8Q5Opx2sOe83Z7uGKNewbjwqzK/itLjEXXIFedw2', 'jOQmur9VbLvv3P3YIa3YhupX0iFauFqZIvAb32vDRbs3oEOikOIb8FcrqE2b', 1, true, true, '2019-06-05 13:43:16', '2019-06-05 13:43:16');
INSERT INTO public.users (id, name, paterno, materno, email, email_verified_at, password, remember_token, created_by, active, confirmed, created_at, updated_at) VALUES (3, 'Alberto Rios Cruz', 'Cruz', NULL, 'cruz@gmail.com', NULL, '$2y$10$Xw4Ux9TiNPMoH9t/MRTrcutKNRa8hM.cY41rr/zvAOuJS3HdFLRHS', NULL, 1, true, true, '2019-06-05 14:18:52', '2019-06-05 14:18:52');
INSERT INTO public.users (id, name, paterno, materno, email, email_verified_at, password, remember_token, created_by, active, confirmed, created_at, updated_at) VALUES (1, 'Administrator', NULL, NULL, 'admin@sibiso.cdmx.gob.mx', NULL, '$2y$10$MS6CfP1oB4lXtk1F/dGeAuJckV7RCRBA.77XkVYmTmYqNCcXK.ZGa', '228nuTIDDTxQzP3vnakvTskBgGdPLOs2R8W5JROXjlPOjFbeZru3waH6sJnY', 1, true, true, NULL, NULL);


--
-- Name: item_rols_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.item_rols_id_seq', 9, true);


--
-- Name: item_value_reports_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.item_value_reports_id_seq', 1, false);


--
-- Name: logs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.logs_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 69, true);


--
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permissions_id_seq', 9, true);


--
-- Name: reports_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reports_id_seq', 1, false);


--
-- Name: rol_structure_items_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.rol_structure_items_id_seq', 9, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 3, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 3, true);


--
-- PostgreSQL database dump complete
--

