---
title: "Software Requirements Specification"
subtitle: "DOST-LIMS — Laboratory Information Management System"
author: "DOST Region IX — Regional Standards and Testing Laboratories (RSTL)"
date: "August 5, 2026"
---

# Software Requirements Specification

**DOST-LIMS: Laboratory Information Management System**

| | |
|---|---|
| **Document version** | 1.0 (Draft) |
| **Date** | August 5, 2026 |
| **Prepared for** | DOST Region IX — Regional Standards and Testing Laboratories (RSTL) |
| **Status** | Draft — reverse-engineered from the current codebase for review and validation by the product owner |

> **Note on methodology.** This SRS was produced by systematically reading the application's routes, controllers, service classes, Eloquent models, and database seeders, rather than from a pre-existing requirements backlog. It therefore documents the system in two complementary layers: (1) formal **"the system shall…"** requirements describing the intended behavior, and (2) an **Appendix D — Current Implementation Notes**, which records places where the running code does not yet fully satisfy a stated requirement (missing access control, unfinished features, dead code, etc.). Section 3 should be read as the specification; Appendix D should be read as a gap/risk register to prioritize before this document is treated as a final, signed-off baseline.

\newpage

## Table of Contents

1. Introduction
2. Overall Description
3. System Features (Functional Requirements)
4. External Interface Requirements
5. Non-Functional Requirements
6. Other Requirements (Legal & Regulatory)
7. Appendix A — Glossary
8. Appendix B — User Roles Reference
9. Appendix C — Status Code Reference
10. Appendix D — Current Implementation Notes (Gap Register)

\newpage

## 1. Introduction

### 1.1 Purpose

This Software Requirements Specification (SRS) describes the functional and non-functional requirements of **DOST-LIMS**, a web-based Laboratory Information Management System used by a DOST (Department of Science and Technology, Philippines) Regional Standards and Testing Laboratory (RSTL) office to manage the full lifecycle of laboratory testing and calibration services — from customer quotation, through sample intake, laboratory analysis, and payment, to signed test-report release — together with the supporting administrative, financial, and management-reporting functions the office depends on.

This document is intended to serve as the authoritative reference for what the system does (and, per Appendix D, does not yet fully do), for use in:
- Onboarding new developers and QA staff;
- Prioritizing a remediation/completion backlog against the gaps identified in Appendix D;
- Supporting internal control, audit, and Data Privacy Act compliance reviews;
- Serving as a baseline for future change requests and formal sign-off by the process owners in each division (Laboratory Operations, Finance/Cashiering, Executive/Administration).

### 1.2 Document Conventions

- Requirements are written as **"The system shall…"** statements and are numbered `FR-<MODULE>-<NN>` (functional) or `NFR-<NN>` (non-functional) for traceability.
- Priority is indicated as **(M)** Must-have / already core to daily operations, **(S)** Should-have / partially built, or **(F)** Future/as-designed-but-not-implemented — cross-referenced to Appendix D where relevant.
- Module abbreviations used in requirement IDs are listed in Appendix A.
- This SRS follows the IEEE 830-1998 recommended content, organized using the "system features" structure (grouping requirements by functional module) because the system comprises more than twenty distinct, loosely-coupled feature areas — a structure better suited to a system of this size than the strict linear IEEE 830 template.

### 1.3 Intended Audience and Reading Suggestions

| Audience | Suggested focus |
|---|---|
| DOST-IX Management / Process Owners | §2 Overall Description, §3 System Features (their division's subsection), §6 Legal & Regulatory |
| Developers / Maintainers | §3 in full, §4 External Interfaces, Appendix C, Appendix D |
| QA / Testers | §3 (as acceptance criteria source), Appendix D (known-gap regression list) |
| Auditors / Data Privacy Officer | §5 Non-Functional Requirements (Security, Privacy), §6, Appendix D |

### 1.4 Product Scope

DOST-LIMS is a **multi-role, multi-subdomain web application** built on Laravel 12 (PHP) with a Vue 3 + Inertia.js front end. It serves three distinct audiences through three separate subdomains of the same codebase:

1. **Staff portal** (main domain) — used by laboratory, administrative, and finance personnel to run the day-to-day test-request-to-release workflow, manage the test-service catalog, process payments, and administer agencies, users, equipment, and inventory.
2. **Customer portal** (`customer.<host>`) — used by external clients (individuals and firms) to request quotations, track the status of submitted samples, download signed test reports, and pay online.
3. **GAD micro-site** (`gad.<host>`) — a public Gender-and-Development transparency/reporting site mandated for Philippine government agencies.

The system is designed to be **agency/laboratory-multi-tenant** (an `Agency` → `AgencyFacility` → `AgencyFacilityLaboratory` data model supports multiple DOST regional offices and their laboratories operating from one shared deployment), although the current production deployment is configured and, in places, hard-coded for a single tenant: **DOST Region IX (Zamboanga Peninsula)**, operating out of the RSTL facility at Pettit Barracks, Zamboanga City. This distinction — designed-for-multi-tenancy vs. configured-for-single-tenancy — is called out throughout §3 and in Appendix D.

**In scope:** quotation and test-sample-request management; sample and analysis tracking; test-report generation, digital signing, and release; test-service/package catalog administration; order-of-payment and official-receipt processing; online payment collection; customer wallet; discount administration; agency/facility/equipment/inventory administration; staff scheduling; user and role administration; management dashboards (Insights, Accomplishment/Target reporting, Monitoring); public QR-based report verification; GAD reporting.

**Out of scope for this document:** the internal design of the external PDF-signing microservice and third-party payment gateways (PayMongo, eGovPay) is documented only at the interface level (§4); their internal implementations are outside this system's boundary.

### 1.5 Definitions, Acronyms, and Abbreviations

See **Appendix A — Glossary**.

### 1.6 References

- IEEE Std 830-1998, *IEEE Recommended Practice for Software Requirements Specifications*.
- Republic Act No. 10173, *Data Privacy Act of 2012* (Philippines).
- Republic Act No. 9710, *Magna Carta of Women* (basis for mandatory GAD reporting).
- Commission on Audit (COA) rules on the use of accountable/pre-numbered Official Receipts.
- The DOST-LIMS source code repository (`dost-lims`), as of August 2026, from which this document was derived.

\newpage

## 2. Overall Description

### 2.1 Product Perspective

DOST-LIMS is a replacement/successor for an earlier system referred to internally as **"eULIMS"** (the phrase appears in the seeded role description for Laboratory Analyst). It is a self-contained, new system rather than an add-on to existing software, but it integrates with several external services:

- **AWS S3** — durable storage for uploaded photos, signature images, digital certificates, and generated PDFs.
- **AWS Rekognition** — facial-recognition credentials are configured but, per Appendix D, not currently wired into any live workflow.
- **PayMongo** — card/GCash/QRPH payment processing for the customer portal.
- **eGovPay (Land Bank of the Philippines gateway)** — government e-payment channel for the customer portal.
- **Google / Facebook OAuth** — optional staff social sign-in (Facebook credentials are not currently configured; see Appendix D).
- **A local PDF-signing microservice** (FastAPI, `127.0.0.1:8000`) — normalizes PDFs (embeds verification QR codes) and applies PKCS#12 (.p12/PNPKI) digital signatures on behalf of the signing officers.
- **A custom SMS gateway** (`api.dost9.ph`) — sends OTP codes and "ready for release" notifications to customers' mobile numbers.
- **Google/Facebook social login**, **Mailgun/Postmark/SMTP** for transactional e-mail.

### 2.2 Product Functions

At a high level, DOST-LIMS provides:

1. **Quotation-to-TSR lab workflow** — quotation drafting, conversion to a formal Test Sample/Service Request (TSR), sample intake, analysis assignment and bench tagging, test-report numbering and multi-stage digital signing, and result releasing.
2. **Test-service catalog management** — configurable catalog of billable tests, methods, add-on fees, sample categorization, and bundled packages.
3. **Financial processing** — Order-of-Payment/Official-Receipt issuance (laboratory and non-laboratory), online payment collection, a customer wallet/credit ledger, and discount administration.
4. **Customer self-service portal** — passwordless (OTP) login, quotation requests, TSR status tracking, signed-report download, and online bill payment.
5. **Administrative management** — agencies, facilities, laboratories, staff accounts and roles, equipment calibration/maintenance tracking, consumable inventory, and staff/resource scheduling.
6. **Management reporting** — customer/payment/laboratory/performance analytics dashboards, target-vs-accomplishment KPI reporting, and a real-time turnaround-time monitoring board.
7. **Public trust services** — QR-code-based public verification of issued test reports, and a Gender-and-Development transparency micro-site.

### 2.3 User Classes and Characteristics

| User class | Description | Typical goals |
|---|---|---|
| Administrator | Sole/near-sole super-user account per deployment | Configure agencies, users, discounts, reference data |
| Laboratory Head | Senior lab officer | Oversight of all lab-module activity |
| Technical Manager | Per-laboratory quality authority | Approves quotations, certifies/approves test reports, can cancel transactions |
| Customer Relation Officer (CRO) | Front-desk / intake officer | Receives samples, manages the request lifecycle end-to-end |
| Laboratory Analyst | Bench scientist | Performs and tags analyses (Chemical/Microbiological labs) |
| Calibration Officer | Bench scientist, calibration lab | Performs and tags calibration analyses |
| Accountant | Finance back-office | Issues Orders of Payment, monitors collections |
| Cashier | Finance front-office | Collects payment, issues Official Receipts |
| Releasing Officer | Result hand-off officer | Notifies and releases signed reports to customers |
| Laboratory Aide | Support staff | Handles physical sample disposal |
| Top Management | Executive stakeholder | Consumes Insights/Accomplishment dashboards |
| Customer (portal) | External client (individual or firm) | Requests quotations, tracks/pays/downloads reports |
| Public / anonymous | Anyone with a report QR code or link | Verifies the authenticity of an issued report |

A full role catalog with intended module access is in **Appendix B**.

### 2.4 Operating Environment

- **Backend:** PHP 8.2, Laravel Framework 12.
- **Frontend:** Vue 3, Inertia.js, Bootstrap 5, with FullCalendar, AmCharts5, ApexCharts, ECharts, Leaflet, and FilePond for specialized UI needs.
- **Database:** MySQL (session, cache, and queue also configurable to database/file drivers).
- **File storage:** AWS S3 (primary), local disk (fallback/dev).
- **Hosting model:** three subdomains of one deployment — the staff portal on the root domain, the customer portal on `customer.<host>`, and the GAD micro-site on `gad.<host>` — sharing one Laravel application and one session/Inertia layer, differentiated by authentication guard (`web` vs. `customer`) and host inspection.
- **Server timezone:** `Asia/Manila`.
- **External runtime dependency:** a companion PDF-normalization/signing microservice must be reachable at a configured local address for the digital-signing features to function.

### 2.5 Design and Implementation Constraints

- The system must comply with **COA rules for accountable Official Receipts** — OR numbers are drawn from pre-defined, sequentially-numbered booklets ("OR series") assigned to a specific cashier, not freely generated by the application (see FR-FIN-04).
- Personally identifiable information (customer/staff names, emails, mobile numbers, TINs, etc.) must be encrypted at rest, consistent with the **Data Privacy Act of 2012** (see §5.3, §6).
- The application is architected for **multi-agency/multi-laboratory tenancy** (every core record carries an `agency_id`, enforced through model-level global scoping) even though only one agency is active in the current deployment; new features should preserve this scoping rather than hard-coding a single agency.
- Digital signing of official test reports must use the signer's own PNPKI-issued PKCS#12 certificate — signatures cannot be applied using a shared or system-wide key.

### 2.6 User Documentation

A static in-app "User Manual" page is provided at `/usermanual`. This SRS is intended to complement, not replace, that operational user guide.

### 2.7 Assumptions and Dependencies

- The office operates under **one primary "regional office" facility**, optionally with subordinate **PSTO (Provincial Science and Technology Office)** facilities that may or may not share the regional laboratory infrastructure.
- Each of the four laboratory disciplines (**Chemical, Microbiological, Metrology, Rubber**) is treated as a first-class dimension across scheduling, targets, staffing, and reporting.
- The PDF-signing microservice and the eGovPay/PayMongo gateways are assumed reachable and correctly configured in production; the system's digital-signing and online-payment features are unavailable if they are not.
- Every staff account is assumed to belong to exactly one facility and one agency, and to hold at least one role, at the time of account creation.

\newpage

## 3. System Features (Functional Requirements)

### 3.1 Authentication, Account Security & Session Management — `AUTH`

**Description.** Staff authenticate on the main portal via the `web` guard; customers authenticate on the customer subdomain via a separate `customer` guard. Staff accounts additionally support optional two-factor authentication and PNPKI certificate provisioning used later for report signing.

| ID | Requirement | Priority |
|---|---|---|
| FR-AUTH-01 | The system shall allow staff to sign in with either their registered e-mail address or username plus password. | M |
| FR-AUTH-02 | The system shall rate-limit sign-in attempts (maximum 3 per account/IP combination within the lockout window) and lock accounts flagged `is_locked` or inactive from signing in. | M |
| FR-AUTH-03 | The system shall force a new staff account through a first-login **Activation** wizard (enter emailed activation code → set a strong password → upload an identification photo → confirm) before granting normal access, and shall set a system-generated temporary password requiring immediate change. | M |
| FR-AUTH-04 | The system shall enforce a strong-password policy (minimum 8 characters, mixed case, letters, numbers, symbols, and rejection of passwords found in known breach corpora) on every password set or reset. | M |
| FR-AUTH-05 | The system shall support an alternative mobile-number OTP sign-in for staff, independent of the password-based flow. | M |
| FR-AUTH-06 | The system shall support optional TOTP-based two-factor authentication (enable, confirm, disable, and recovery-code regeneration) per staff account, and shall challenge for the 2FA code on every new session once enabled. | M |
| FR-AUTH-07 | The system shall support staff sign-in via Google OAuth, automatically linking to an existing account matched by e-mail, or provisioning a new account requiring activation. | S |
| FR-AUTH-08 | The system shall support "confirm password" re-authentication before sensitive actions, locking the session until confirmed. | M |
| FR-AUTH-09 | The system shall support self-service password reset via an e-mailed, time-limited reset link. | M |
| FR-AUTH-10 | The system shall allow a staff member to view and terminate their other active sessions from their profile. | S |
| FR-AUTH-11 | The system shall allow a staff member, from their own profile, to upload their PNPKI PKCS#12 certificate, its password, and a visual signature image, for later use in test-report digital signing. Certificate passwords shall be stored encrypted, never in plaintext. | M |
| FR-AUTH-12 | The system shall restrict every staff-portal route to authenticated, e-mail-verified, 2FA-satisfied sessions, and shall further restrict specific modules (Finance, Executive/Administration, Releasing) to the staff member's assigned role(s). | M |
| FR-AUTH-13 | The system shall log an authentication log entry for sign-in events and an activity-log entry for security-relevant profile changes, retrievable by an Administrator. | S |

### 3.2 Customer Portal — `CUST`

**Description.** External clients self-serve on the `customer.<host>` subdomain using a dedicated `Customer` identity model (distinct from staff `User`s), authenticated without a password.

| ID | Requirement | Priority |
|---|---|---|
| FR-CUST-01 | The system shall authenticate customers via a passwordless flow: the customer submits their registered e-mail, receives a one-time numeric code, and enters it to sign in. | M |
| FR-CUST-02 | The system shall rate-limit OTP requests per requesting IP and enforce a minimum resend interval and a short code-expiry window. | M |
| FR-CUST-03 | Customer accounts shall be provisioned by staff (via the Customer/Agency-side customer management screens), not through public self-registration. | M |
| FR-CUST-04 | A customer firm/company (`CustomerName`) may have one or more branch records (`Customer`), each independently trackable, with one designated as the main branch. | M |
| FR-CUST-05 | The system shall let a customer view a dashboard summarizing their TSRs by status (For Payment / Ongoing / Completed), upcoming sample-collection schedule entries tied to them, and reports ready for pickup. | M |
| FR-CUST-06 | The system shall let a customer view a paginated list of their own TSRs, including payment and per-sample report/signature status, and shall not expose another customer's TSRs. | M |
| FR-CUST-07 | The system shall let a customer download a printable acknowledgment slip (with embedded verification QR code) for a submitted TSR. | M |
| FR-CUST-08 | The system shall let a customer open/download the signed PDF of a completed, released test report once available. | M |
| FR-CUST-09 | The system shall let a customer draft a quotation online (add samples and requested test services per sample) with running subtotal/discount/total calculation, scoped to that authenticated customer only. | S |
| FR-CUST-10 | The system shall let a customer pay an outstanding TSR balance online via PayMongo (card/GCash/QRPH) or the government eGovPay gateway, and reflect a successful payment back onto the TSR without staff intervention. | M |
| FR-CUST-11 | Customer contact information (e-mail, mobile number, TIN) shall be stored encrypted at rest, with lookups performed against a separate deterministic hash rather than the plaintext/ciphertext value. | M |

### 3.3 Quotation Management — `QUO`

**Description.** A quotation is a non-binding cost estimate that mirrors the sample/analysis/fee structure of a TSR and can later be converted into one.

| ID | Requirement | Priority |
|---|---|---|
| FR-QUO-01 | The system shall allow authorized staff to create a draft quotation for a customer, capturing purpose, laboratory, facility, release mode, and optional external-referral information. | M |
| FR-QUO-02 | The system shall allow one or more samples to be added to a quotation, each with one or more requested test services (analyses), computing a running subtotal per line. | M |
| FR-QUO-03 | The system shall allow onsite/add-on service fees to be attached either to the whole quotation or to an individual analysis line. | M |
| FR-QUO-04 | The system shall recompute the quotation's discount and total automatically, as a percentage of the current subtotal, every time a sample, analysis, or fee line is added or removed. | M |
| FR-QUO-05 | The system shall permit editing of a quotation's header fields and line items only while its status is Pending or Ongoing; a Completed or Cancelled quotation shall be immutable. | M |
| FR-QUO-06 | The system shall allow a full quotation to be cloned ("copy") into a new draft quotation, and allow a single sample within a quotation to be duplicated N times, optionally including its test services. | S |
| FR-QUO-07 | The system shall allow a quotation to be cancelled, permanently freezing the record. | M |
| FR-QUO-08 | Upon finalization, the system shall assign the quotation a unique, sequential, laboratory/agency/year-scoped reference code and route it through a Prepared → Approved (by the laboratory's Technical Manager) → Received sign-off chain. | M |
| FR-QUO-09 | The system shall allow a finalized quotation to be converted, in full, into a new Test Sample/Service Request, deep-copying all samples, analyses, fees, and referral information, and marking the source quotation Completed. | M |
| FR-QUO-10 | The system shall produce a printable PDF quotation slip embedding a QR code for later reference/verification and a tamper-evidence marker computed over the document. | S |

### 3.4 Test Sample / Service Request (TSR) Management — `TSR`

**Description.** The TSR is the authoritative transaction record for a laboratory engagement, from intake through completion.

| ID | Requirement | Priority |
|---|---|---|
| FR-TSR-01 | The system shall allow a new TSR to be created directly (walk-in) or via quotation conversion, defaulting to Pending status. | M |
| FR-TSR-02 | The system shall allow an existing TSR to be duplicated ("copy") into a new Pending TSR, including its payment, referral, services, samples, and analyses. | S |
| FR-TSR-03 | Upon intake confirmation, the system shall assign the TSR a unique sequential control number and assign each of its samples a unique sequential sample code, both scoped by laboratory, facility, agency, and year, generated under row-level locking to prevent duplicate issuance under concurrent use. | M |
| FR-TSR-04 | Upon confirmation, the system shall capture a due date and generate an immutable, encrypted JSON snapshot of the full transaction (customer, samples, analyses, fees, payment) for later printing/verification, together with a randomly generated verification passkey. | M |
| FR-TSR-05 | The system shall automatically advance a TSR's status to Ongoing, bypassing the "For Payment" gate, when its associated discount is one of the fully-subsidized/gratis categories, or when the request is flagged as a government transaction billed under an agency contract/MOA. | M |
| FR-TSR-06 | The system shall allow a Cashier to mark a TSR's payment as received, transitioning the TSR to Ongoing status. | M |
| FR-TSR-07 | The system shall allow authorized staff to cancel a TSR while it is Pending or For Payment, requiring a recorded cancellation reason and reverting its payment status accordingly. | M |
| FR-TSR-08 | The system shall permit editing of a TSR's header/discount only while its status is Pending or For Payment; later-stage TSRs shall be immutable except through the defined status-transition actions (payment, analysis tagging, report, release, cancellation). | M |
| FR-TSR-09 | Changing a TSR's discount to a fully-subsidized/gratis category after creation shall automatically mark its payment Gratis/paid and, if the TSR was awaiting payment, advance it to Ongoing. | M |
| FR-TSR-10 | The system shall automatically transition a TSR to Completed status once none of its analyses remain Pending or Ongoing, and shall automatically flag each sample Completed (and queue it for disposal) once none of that sample's analyses remain Pending or Ongoing. | M |
| FR-TSR-11 | The system shall produce a printable TSR slip (multiple copies per sheet) embedding a QR code linking to the public verification page. | M |
| FR-TSR-12 | The system shall restrict staff and customers to viewing only TSRs belonging to their own agency (staff) or their own customer account (customer portal), except for the Administrator role. | M |

### 3.5 Sample & Analysis Management — `SAM`

| ID | Requirement | Priority |
|---|---|---|
| FR-SAM-01 | The system shall maintain a laboratory-scoped hierarchy of Sample Category → Sample Type → Sample Name, used to classify every sample. | M |
| FR-SAM-02 | The system shall allow staff to add one or more samples to a TSR in bulk, optionally cloning the test services of a previously entered sample. | M |
| FR-SAM-03 | The system shall allow staff to attach one or more catalog test services (individually, or as a Package bundle) to a sample as billable analyses, and shall recompute the TSR's totals accordingly. | M |
| FR-SAM-04 | The test-service picker shall support filtering by the services explicitly tagged as applicable to the selected sample type/name, in addition to package selection and free-text search, restricted to the active catalog of the relevant laboratory. | M |
| FR-SAM-05 | The system shall allow a Laboratory Analyst or Calibration Officer to mark one or more assigned analyses as "started" (recording who and when) and later "completed" (recording who and when), individually or in bulk (including a batch/QR-scan-driven group mode). | M |
| FR-SAM-06 | Analyst/Calibration-Officer work queues (Pending, Ongoing, Completed-without-report-number) shall be restricted to the laboratories for which that staff member holds an active analyst/calibration role. | M |
| FR-SAM-07 | The system shall allow an individual analysis to be cancelled or refunded; a refund shall credit the corresponding fee back to the customer's wallet with an auditable transaction record. | M |
| FR-SAM-08 | The system shall allow recording of physical sample disposal (date, method, responsible staff), queued automatically once a sample's analyses are all complete. | M |

### 3.6 Test Report Generation, Digital Signing & Releasing — `RPT`

| ID | Requirement | Priority |
|---|---|---|
| FR-RPT-01 | The system shall allow a unique, sequential test-report number to be issued for one or more fully-completed samples belonging to the same TSR, refusing to issue a duplicate number for a sample already reported. | M |
| FR-RPT-02 | Each issued test report shall carry a three-stage sign-off chain — Analyzed → Certified → Approved — each stage recording the responsible staff member and timestamp. | M |
| FR-RPT-03 | The system shall route each pending report to the correct staff member's personal "awaiting my signature" queue based on the current sign-off stage. | M |
| FR-RPT-04 | The system shall digitally sign the report PDF at each sign-off stage using the responsible staff member's own PNPKI certificate, placed at a staff-selected position on the document, via the configured external signing service. | M |
| FR-RPT-05 | The first signing pass on a report shall normalize the PDF and embed a QR code linking to the report's public verification page. | M |
| FR-RPT-06 | The system shall allow the attached report file to be replaced (re-uploaded), resetting the sign-off chain to its initial stage. | S |
| FR-RPT-07 | The system shall support ad-hoc normalization and digital signing of an arbitrary staff-uploaded PDF document, independent of the TSR/report workflow. | S |
| FR-RPT-08 | Upon a report becoming ready, the system shall create a release record and notify the customer (SMS) that their results are ready for pickup. | M |
| FR-RPT-09 | The system shall allow a Releasing Officer to record the hand-off of results to the customer, capturing the releasing staff member and timestamp. | M |
| FR-RPT-10 | The system shall surface "Due Soon," "Overdue," "For Release," and "Unclaimed (>30 days)" release-status buckets to support proactive follow-up. | M |

### 3.7 Test-Service Catalog & Package Management — `CAT`

| ID | Requirement | Priority |
|---|---|---|
| FR-CAT-01 | The system shall allow authorized staff to define billable test services per laboratory, each with a name, analytical method/reference standard, and base fee. | M |
| FR-CAT-02 | A newly added or edited test service shall enter a Pending-approval state and shall not be available for selection on a quotation/TSR until approved. | M |
| FR-CAT-03 | The system shall allow test services to be tagged to the specific sample types/names they apply to, driving the filtered picker used during analysis assignment. | M |
| FR-CAT-04 | The system shall allow one or more optional add-on fees to be defined against a test service. | M |
| FR-CAT-05 | The system shall allow bundled Packages of test services (with an overridable per-service fee) to be defined and offered as a single selectable unit. | M |
| FR-CAT-06 | The system shall support bulk import of catalog test services from a spreadsheet. | S |
| FR-CAT-07 | The system shall maintain the Sample Category/Type/Name hierarchy referenced by §3.5 through a dedicated administrative screen. | M |

### 3.8 Finance: Order of Payment & Official Receipts — `FIN`

| ID | Requirement | Priority |
|---|---|---|
| FR-FIN-01 | The system shall restrict Order-of-Payment and Official-Receipt functions to staff holding the Accountant or Cashier role. | M |
| FR-FIN-02 | The system shall allow an Accountant to select one or more unpaid TSRs for the same customer and consolidate them into a single Order of Payment (OP), assigning a unique sequential OP code. | M |
| FR-FIN-03 | The system shall allow a TSR to be removed from a pending OP, but shall prevent removal of the last remaining item on an OP. | M |
| FR-FIN-04 | Official Receipt numbers shall be drawn, in strict sequence, from a pre-defined OR series ("booklet") assigned to and usable only by a specific Cashier; the system shall mark a series finished once its range is exhausted and shall require a new series before further receipts can be issued. | M |
| FR-FIN-05 | Upon issuing an Official Receipt against an OP, the system shall mark the OP Paid, mark every covered TSR's payment as paid (recording the OR number and payment date), and advance each covered TSR to Ongoing status, all within a single atomic transaction. | M |
| FR-FIN-06 | The system shall record the payment instrument detail (cheque/bank/reference number, date) for non-cash payments, and validate that the tendered amount is not zero and not less than the OP total. | M |
| FR-FIN-07 | If the amount tendered exceeds the OP total, the system shall credit the excess to the customer's wallet rather than reject or silently discard it. | M |
| FR-FIN-08 | The system shall allow an issued Official Receipt to be cancelled with a recorded reason, permanently voiding that receipt number and reverting the linked OP and TSR payment statuses to unpaid. | M |
| FR-FIN-09 | The system shall support Orders of Payment and Receipts for non-laboratory payors/charges (e.g., inter-agency fees), using the same receipt-numbering and cancellation controls as laboratory transactions. | M |
| FR-FIN-10 | The system shall allow batching of a range of Official Receipts into a bank-deposit record for reconciliation purposes. | S |
| FR-FIN-11 | The system shall provide month/year/laboratory-scoped Excel exports for: OP–OR reconciliation, OP–OR pairing, RSTL statutory collection data, and full TSR/collection detail. | M |

### 3.9 Online / Digital Payments — `PAY`

| ID | Requirement | Priority |
|---|---|---|
| FR-PAY-01 | The system shall allow a customer to pay an outstanding TSR balance via a hosted checkout session supporting GCash and QRPH. | M |
| FR-PAY-02 | The system shall allow a customer to pay via a direct QRPH payment intent, computing and disclosing an online-convenience fee on top of the base amount before payment. | M |
| FR-PAY-03 | The system shall allow a customer to pay via the government eGovPay/Land Bank channel, including a scannable Land Bank QR code. | S |
| FR-PAY-04 | Upon confirmed successful payment from any online channel, the system shall automatically mark the corresponding TSR payment as paid and advance the TSR to Ongoing status without requiring cashier intervention. | M |
| FR-PAY-05 | Each online payment attempt shall be recorded with its method, gateway reference/transaction identifiers, amount, fee, and status, providing an audit trail independent of the underlying TSR payment record. | M |
| FR-PAY-06 | Inbound payment-gateway webhook notifications shall be authenticated (signature/HMAC verified) before being trusted to alter payment state. | M — see Appendix D (currently not implemented) |

### 3.10 Wallet Management — `WAL`

| ID | Requirement | Priority |
|---|---|---|
| FR-WAL-01 | The system shall maintain one wallet (available balance) per customer, credited automatically from payment overages and refunded/cancelled analyses. | M |
| FR-WAL-02 | The system shall allow a Cashier to apply a customer's wallet balance toward an outstanding TSR payment, fully or partially. | M |
| FR-WAL-03 | If a wallet balance fully covers a TSR's outstanding amount, the system shall mark the payment complete without requiring a separate Official Receipt transaction. | M |
| FR-WAL-04 | If a wallet balance only partially covers the outstanding amount, the system shall record the partial deduction and reduce the remaining balance due, leaving the remainder to be settled through the standard OP/OR flow. | M |
| FR-WAL-05 | Every wallet credit or debit shall be recorded as an individually auditable transaction, linked to its originating document (receipt, TSR, refund) and showing the resulting balance. | M |
| FR-WAL-06 | Authorized staff shall be able to view a customer's wallet balance and transaction history. | S — see Appendix D (list view currently unreachable) |

### 3.11 Discount Management — `DIS`

| ID | Requirement | Priority |
|---|---|---|
| FR-DIS-01 | The system shall maintain a global catalog of discount types, each with a percentage value, applicability classification (individual vs. institutional), and active flag. | M |
| FR-DIS-02 | The system shall allow each agency to independently enable or disable which catalog discounts (including seasonal/occasional ones) are offered at that agency. | M |
| FR-DIS-03 | The system shall recompute a quotation's or TSR's discount amount as the configured percentage of its current subtotal every time line items change, rather than freezing the discount amount at initial selection. | M |
| FR-DIS-04 | The system shall treat a defined set of discount categories (fully-subsidized, gratis, gratis-calibration, gratis-R&D, gratis-QC, health units) as 100%-off, automatically marking the associated payment as free/paid and bypassing the payment gate. | M |
| FR-DIS-05 | The system shall provide discount-utilization reporting (by discount category, by laboratory, by month) for management review. | M |

### 3.12 Agency, Facility & Laboratory Management — `AGN`

| ID | Requirement | Priority |
|---|---|---|
| FR-AGN-01 | The system shall maintain a directory of testing agencies/institutions (DOST regional offices, attached institutes, and partner/accredited external labs) used for recording and referring out samples the local laboratory cannot process. | M |
| FR-AGN-02 | The system shall allow an Administrator to activate an agency, at which point that agency's laboratory system access, discount configuration, and form settings become available. | M |
| FR-AGN-03 | The system shall allow one or more physical facility sites to be defined under an agency, each classified as a Regional Office or a Provincial Science and Technology Office (PSTO), and, for a PSTO, whether it operates a physically separate laboratory. | M |
| FR-AGN-04 | The system shall allow each facility to be assigned one or more of the defined laboratory disciplines (Chemical, Microbiological, Metrology, Rubber). | M |
| FR-AGN-05 | The system shall allow the designation of the Accountant and Cashier of record for each facility, used to determine signing authority on printed financial documents. | M |
| FR-AGN-06 | Every agency-scoped record in the system (transactions, catalog entries, staff, discounts, financial documents) shall be automatically restricted to the acting staff member's own agency, except for the Administrator role. | M |

### 3.13 Equipment Management — `EQP`

| ID | Requirement | Priority |
|---|---|---|
| FR-EQP-01 | The system shall maintain a register of laboratory equipment, including acquisition details (manufacturer, model, serial number, supplier, cost, acquisition date). | M |
| FR-EQP-02 | The system shall track each piece of equipment's next calibration due date and next maintenance due date. | M |
| FR-EQP-03 | The system shall allow a calibration or maintenance event to be logged against a piece of equipment, and shall automatically roll the corresponding due date forward to the next scheduled date. | M |
| FR-EQP-04 | The system shall present equipment due-date status in Complete / Due Soon (within 30 days) / Overdue / Unscheduled buckets, excluding disposed or not-in-use equipment from the due/overdue counts. | M |
| FR-EQP-05 | The system shall allow equipment to be marked Operational, Disposed, or Not in Use. | M |

### 3.14 Inventory Management — `INV`

| ID | Requirement | Priority |
|---|---|---|
| FR-INV-01 | The system shall maintain a catalog of consumable/reagent inventory items, each with a unique code, unit of measure, category, and reorder threshold. | M |
| FR-INV-02 | The system shall allow new stock lots to be received ("stock-in"), recording quantity, brand, lot/CAS number, cost, supplier, purchase date, and expiry date. | M |
| FR-INV-03 | The system shall flag items that are out of stock, expired, or at/below their reorder threshold. | M |
| FR-INV-04 | The system shall support normalizing stock quantities recorded in a different unit of measure than the item's canonical unit (e.g., mL↔L, g↔kg) for reorder/on-hand calculations. | S |
| FR-INV-05 | The system shall allow staff to withdraw/check out inventory items against a borrower, recording quantity and timestamp, and shall deduct the withdrawn quantity from on-hand stock. | S — see Appendix D (currently not implemented end-to-end) |

### 3.15 Scheduling — `SCH`

| ID | Requirement | Priority |
|---|---|---|
| FR-SCH-01 | The system shall provide a shared agency calendar supporting configurable event types (in-house/on-site calibration, sample-pickup schedules by test type, official travel/meetings/audits, leave, holidays, GAD activities, others), each controlling which optional fields (venue, customer, samples, related TSR/quotation, attendees) are captured. | M |
| FR-SCH-02 | The system shall allow a calendar event to target either the whole agency or a specific list of assigned staff. | M |
| FR-SCH-03 | The system shall automatically mark the office closed for any event of type "Holiday." | M |
| FR-SCH-04 | The system shall allow a schedule entry to be linked to a specific customer, quotation, or TSR, to represent a sample-collection or field-testing appointment. | M |
| FR-SCH-05 | The system shall overlay a TSR due-date heat-map on the scheduling calendar to support turnaround-time planning. | S |
| FR-SCH-06 | The system shall restrict editing of a schedule entry to its creator (or an Administrator). | M |

### 3.16 User & Role Administration — `USR`

| ID | Requirement | Priority |
|---|---|---|
| FR-USR-01 | The system shall restrict staff-account and role administration to the Administrator role. | M |
| FR-USR-02 | The system shall require every new staff account to be assigned exactly one facility, one agency, and at least one initial role at creation time, and shall issue a system-generated temporary password requiring change on first login. | M |
| FR-USR-03 | The system shall allow a staff member to hold multiple roles, each optionally scoped to a specific laboratory, with one role designated primary (used to select their default dashboard). | M |
| FR-USR-04 | The system shall allow a role to be deactivated from a user without deleting the historical assignment record (soft removal, retaining who removed it and when). | M |
| FR-USR-05 | The system shall allow an Administrator to activate/deactivate a staff account and to reset a staff member's credentials, issuing a new activation code. | M |
| FR-USR-06 | The system shall present authentication logs and activity/audit logs per staff account for review. | M |

### 3.17 GAD (Gender and Development) Reporting Micro-site — `GAD`

| ID | Requirement | Priority |
|---|---|---|
| FR-GAD-01 | The system shall publish a public GAD information page (program information, IEC materials, organizational chart) on a dedicated subdomain. | M |
| FR-GAD-02 | The system shall present a gender-disaggregated internal workforce statistics dashboard (headcount by sex, age distribution, role distribution) to authorized staff. | M |
| FR-GAD-03 | The system shall present gender/enterprise-led-disaggregated client transaction statistics (counts and peso value of services rendered to male-led/female-led/individual clients), by month and by geographic distribution, for the agency's current reporting year. | M |
| FR-GAD-04 | The system shall isolate and report separately on transactions using the Women's-Month-related discount category, to support GAD accomplishment reporting. | M |

### 3.18 Insights & Analytics Dashboards — `INS`

| ID | Requirement | Priority |
|---|---|---|
| FR-INS-01 | The system shall provide customer analytics: new/active/returning customer counts and trends, firm-vs-individual mix, top requesting and top spending customers, industry/sub-industry breakdown, and geographic distribution, filterable by period and laboratory. | M |
| FR-INS-02 | The system shall provide a discount-utilization view broken down by discount category, with peso and count totals, exportable to Excel. | M |
| FR-INS-03 | The system shall classify customers by request frequency (monthly/quarterly/semiannual/yearly requester) per laboratory. | S |
| FR-INS-04 | The system shall provide an operational performance dashboard: per-laboratory request/sample/analysis/fee totals, and "Top N" leaderboards for samples, test services, and served customers, filterable by period and internal/external customer classification. | M |
| FR-INS-05 | The system shall provide a laboratory-level analytics dashboard summarizing volume and revenue per laboratory discipline. | F — see Appendix D (not yet implemented) |
| FR-INS-06 | The system shall provide a payment/revenue analytics dashboard. | F — see Appendix D (not yet implemented) |
| FR-INS-07 | Access to all Insights dashboards shall be restricted to authorized management roles. | M — see Appendix D (currently unrestricted) |

### 3.19 Accomplishment / Target Reporting — `ACC`

| ID | Requirement | Priority |
|---|---|---|
| FR-ACC-01 | The system shall allow management to define annual, per-laboratory numeric or peso-value targets against a catalog of performance objectives (e.g., samples received, services conducted, customers served, fees collected, value of assistance rendered, referrals to/from PSTOs). | M |
| FR-ACC-02 | The system shall allow a single overall target to be entered and automatically distributed across its sub-breakdown rows (evenly, with any remainder allocated to the first rows) rather than requiring each row to be entered manually. | S |
| FR-ACC-03 | The system shall compute each objective's actual accomplishment figure live from operational data (TSR/sample/analysis/report records) for the selected period and laboratory, and display it alongside its target and percentage achieved. | M |
| FR-ACC-04 | The system shall provide a drill-down breakdown of "value of assistance rendered" figures by discount/gratis category. | S |
| FR-ACC-05 | The system shall provide both a tabular and a chart-based visualization of target-vs-accomplishment figures. | M |
| FR-ACC-06 | Target-setting and accomplishment reporting shall be scoped to the acting user's own agency, except for the Administrator role. | M |
| FR-ACC-07 | Write access to target figures shall be restricted to authorized management roles. | M — see Appendix D (currently unrestricted) |
| FR-ACC-08 | The system shall support quality/turnaround-time objectives (e.g., percentage of reports issued on time, percentage result accuracy) in the objective catalog. | F — see Appendix D (defined but not computed) |

### 3.20 Monitoring Dashboard — `MON`

| ID | Requirement | Priority |
|---|---|---|
| FR-MON-01 | The system shall present a real-time board of in-progress TSRs requiring attention: due soon (within 5 days), overdue, pending MOA/government payment, awaiting report, and ongoing analyses. | M |
| FR-MON-02 | The system shall present per-laboratory ongoing-transaction counts and load percentages. | M |
| FR-MON-03 | The system shall allow filtering the monitoring list by keyword (customer/TSR code), laboratory, date range, and named reminder bucket (MOA, Due Soon, Overdue, Report Pending, For Release, Unclaimed, Completed-without-report, Ongoing Analyses). | M |

### 3.21 Search — `SRC`

| ID | Requirement | Priority |
|---|---|---|
| FR-SRC-01 | The system shall provide type-ahead lookups (capped result sets) for: cascading Philippine address levels (province/municipality/barangay), TSR/sample codes, staff by name, and customers/payors by name, for use across data-entry forms. | M |

### 3.22 Public Verification — `VER`

| ID | Requirement | Priority |
|---|---|---|
| FR-VER-01 | The system shall provide a public, unauthenticated page that, given the code embedded in a report's QR code, displays the corresponding TSR or sample-report's reference number, dates, customer, payment status, and test/analysis results, to allow a third party to confirm a report's authenticity. | M |
| FR-VER-02 | The verification page's addressing scheme shall not expose sequential/guessable identifiers of unrelated records. | M |
| FR-VER-03 | The system should require presentation of the report's dedicated verification passkey (in addition to the QR-embedded reference) before disclosing full transaction detail, to prevent verification by URL-guessing alone. | S — see Appendix D (passkey/secret key is generated but not currently checked) |

\newpage

## 4. External Interface Requirements

### 4.1 User Interfaces

- All staff- and customer-facing screens are rendered as a Vue 3 single-page application via Inertia.js (server-driven routing, client-side rendering), styled with Bootstrap 5.
- The application shall be usable on desktop browsers at minimum; specific mobile/responsive breakpoints are a UI-design concern outside this SRS's scope.
- Print-oriented outputs (quotations, TSR slips, sample QR labels, official receipts, financial reports) are rendered server-side to PDF for consistent hard-copy output.

### 4.2 Hardware Interfaces

- No specialized laboratory-instrument hardware interface exists; equipment records are administrative (calibration/maintenance tracking), not live instrument data capture.
- QR-code scanning (for sample labels, batch analysis tagging, and inventory checkout) is performed via a camera-equipped client device using standard browser capabilities; no dedicated scanner hardware driver is required.

### 4.3 Software Interfaces

| Interface | Purpose | Protocol |
|---|---|---|
| AWS S3 | Storage of avatars, signature images, PNPKI certificates, uploaded/generated documents | HTTPS (AWS SDK) |
| AWS Rekognition | Facial-recognition indexing (configured; not currently used by any live workflow — see Appendix D) | HTTPS (AWS SDK) |
| PayMongo | Card / GCash / QRPH payment processing, checkout sessions, webhooks | HTTPS REST + webhook |
| eGovPay (Land Bank) | Government e-payment channel, LandBank QR generation | HTTPS REST |
| Google OAuth | Staff social sign-in | OAuth 2.0 |
| Local PDF-signing microservice | PDF normalization (QR embedding) and PKCS#12 digital signing | HTTP REST (`127.0.0.1:8000`) |
| Custom SMS gateway (`api.dost9.ph`) | OTP delivery, release-ready notifications | HTTPS REST |
| SMTP / Mailgun / Postmark | Transactional e-mail (OTP, activation codes, password reset) | SMTP / HTTPS |

### 4.4 Communications Interfaces

- All external and internal traffic is expected over HTTPS in production; the local signing microservice is reached over plain HTTP on `127.0.0.1` and is therefore assumed to run co-located with the application server, not across an untrusted network.
- Inbound payment-gateway callbacks (PayMongo webhook, eGovPay callback) are received as unauthenticated public HTTP endpoints and must be independently secured (see NFR-SEC-04 and Appendix D).

\newpage

## 5. Non-Functional Requirements

### 5.1 Performance

- **NFR-PERF-01.** Sequential code generation (TSR, sample, report, quotation, and OP numbers) shall use row-level database locking to guarantee uniqueness under concurrent multi-user issuance without producing duplicate or skipped numbers.
- **NFR-PERF-02.** List and dashboard views shall be paginated and filterable rather than loading unbounded result sets, consistent with the patterns already used throughout the TSR, Monitoring, and Insights modules.

### 5.2 Security

- **NFR-SEC-01.** Every module handling financial transactions, staff administration, or agency configuration shall enforce role-based access control at the route level, not solely through UI visibility.
- **NFR-SEC-02.** Management-reporting modules (Insights, Accomplishment/Target, Financial Reports) shall be restricted to authenticated sessions holding an appropriate management role; they shall not be reachable by anonymous users (see Appendix D — currently a gap).
- **NFR-SEC-03.** One-time codes (customer login OTP, staff mobile OTP, activation codes) shall be rate-limited, time-limited, and compared using constant-time comparison to resist timing attacks and brute-force guessing.
- **NFR-SEC-04.** Inbound webhook endpoints from payment providers shall verify the provider's request signature/HMAC before trusting the payload to alter payment or transaction state.
- **NFR-SEC-05.** Digital signing of official documents shall always be performed with the acting signatory's own individually issued certificate; a document shall never be attributable to a signatory role without that specific individual's credential having been used.
- **NFR-SEC-06.** Session cookies shall be `HttpOnly`, `SameSite=Lax` at minimum, and `Secure` in production.

### 5.3 Data Protection & Privacy

- **NFR-PRIV-01.** Personally identifiable information — customer and staff e-mail addresses, mobile numbers, TINs, birthdates, and names where feasible — shall be encrypted at rest, with equality lookups performed via a separate deterministic hash rather than by decrypting stored values.
- **NFR-PRIV-02.** Public verification pages shall disclose the minimum information necessary to establish a report's authenticity and shall not be treated as a general-purpose customer-record lookup.
- **NFR-PRIV-03.** Access to another agency's data shall require the Administrator role; ordinary staff shall never see data outside their own assigned agency.

### 5.4 Reliability & Availability

- **NFR-REL-01.** Multi-step financial state changes (e.g., OR issuance updating the OP, TSR payment, and TSR status together) shall be performed within a single atomic database transaction, so that a failure partway through cannot leave the records in an inconsistent state.
- **NFR-REL-02.** Loss of connectivity to an external dependency (payment gateway, signing microservice, SMS gateway) shall degrade only the specific feature that depends on it (online payment, digital signing, notifications) without preventing use of the rest of the system.

### 5.5 Auditability

- **NFR-AUD-01.** Creation, modification, and cancellation of quotations, TSRs, analyses, test-service catalog entries, financial documents, and wallet transactions shall be recorded in a queryable activity log identifying the acting user and timestamp.
- **NFR-AUD-02.** Every monetary movement (Official Receipt, cancellation, wallet credit/debit, deduction) shall be traceable to the specific document or transaction that caused it.

### 5.6 Usability

- **NFR-USE-01.** Each staff role shall be presented with a role-appropriate default dashboard summarizing the work items relevant to that role (e.g., analysts see their tagging queue; cashiers see pending receipts; releasing officers see pending releases).
- **NFR-USE-02.** Monetary values shall be displayed consistently formatted (currency symbol, thousands separators, two decimal places) throughout the system.

### 5.7 Maintainability

- **NFR-MAINT-01.** New agency/laboratory deployments shall be supportable through configuration/data (activating an `Agency`, its facilities, and laboratories) rather than through code changes; modules that currently hard-code a specific agency identifier or reporting year (see Appendix D) should be brought into line with this requirement over time.

\newpage

## 6. Other Requirements (Legal & Regulatory)

- **LR-01 (COA compliance).** Official Receipts must be issued from pre-numbered, sequentially controlled series in a manner consistent with Commission on Audit rules for accountable forms; a voided/cancelled OR number must never be reused (see FR-FIN-04, FR-FIN-08).
- **LR-02 (Data Privacy Act of 2012).** Collection, storage, and processing of customer and staff personal data shall follow the Data Privacy Act's principles of transparency, legitimate purpose, and proportionality; encrypted-at-rest storage of PII (NFR-PRIV-01) is a baseline control toward this, not a complete compliance program — a data privacy impact assessment is recommended before this SRS is finalized.
- **LR-03 (Magna Carta of Women / GAD reporting, RA 9710).** The system shall support the agency's mandatory annual GAD Plan and Budget accomplishment reporting through the gender-disaggregated statistics described in §3.17.
- **LR-04 (Electronic signatures).** Digital signing of official test reports using PNPKI-issued certificates is intended to satisfy the evidentiary requirements for electronic documents under Philippine e-commerce/e-signature law; legal counsel should confirm the specific implementation (external signing microservice, §4.3) meets that standard before reports are treated as legally equivalent to wet-ink-signed documents.

\newpage

## Appendix A — Glossary

| Term | Meaning |
|---|---|
| TSR | Test Sample Request / Test Sample Report — the core lab-transaction record covering a customer's submitted samples from intake to release. |
| OP | Order of Payment — a billing statement issued by the Accountant prior to collection. |
| OR | Official Receipt — the accountable, pre-numbered proof-of-collection document issued by the Cashier. |
| RSTL | Regional Standards and Testing Laboratory — the DOST regional office type operating this system. |
| PSTO | Provincial Science and Technology Office — a provincial DOST field office, which may share or operate a separate laboratory from its regional office. |
| PNPKI | Philippine National Public Key Infrastructure — the government digital-certificate scheme used for the report-signing feature. |
| GAD | Gender and Development — the mandated Philippine government reporting/transparency program. |
| MOA | Memorandum of Agreement — used here for government/contract-billed transactions that bypass the normal payment gate. |
| Gratis | A 100%-discounted (free) transaction category. |
| CRO | Customer Relation Officer — the front-desk role that manages sample intake through release. |
| Hashids | A reversible ID-obfuscation scheme used to avoid exposing raw sequential database IDs in URLs (not a cryptographic access control). |
| Inertia.js | The library bridging the Laravel backend and Vue 3 frontend as a single-page application without a separate JSON API layer. |

## Appendix B — User Roles Reference

| Role | Primary module access | Notes |
|---|---|---|
| Administrator | Full system; Users, Agencies, References, Discounts | Intended as a single/near-single account |
| Laboratory Head | Lab-module oversight | |
| Technical Manager | Quotation approval, report certification/approval, transaction cancellation authority | Resolved per-laboratory |
| Customer Relation Officer | Full quotation/TSR/sample lifecycle (intake-facing) | |
| Laboratory Analyst | Sample/analysis tagging (Chemical, Microbiological) | |
| Calibration Officer | Sample/analysis tagging (Metrology) | |
| Accountant | Orders of Payment, collection monitoring | Route-enforced |
| Cashier | Official Receipts, cashiering, OR series | Route-enforced |
| Releasing Officer | Result releasing | Route-enforced |
| Laboratory Aide | Sample disposal | |
| Top Management | Insights / Accomplishment dashboards (intended) | Not currently route-enforced — see Appendix D |
| Customer | Customer portal only (separate guard) | No password; OTP login |
| Public / anonymous | Report verification page only | No login |

## Appendix C — Status Code Reference

**Request status (`Tsr.status_id` / `Quotation.status_id`, type "Request")**

| ID | Name |
|---|---|
| 1 | Pending |
| 2 | For Payment |
| 3 | Ongoing |
| 4 | Completed |
| 5 | Cancelled |

**Payment status (`TsrPayment.status_id`, type "Payment")**

| ID | Name |
|---|---|
| 6 | Pending |
| 7 | Paid |
| 8 | Gratis |
| 9 | Cancelled |
| 18 | Contract (MOA / government) |

**Analysis status (`TsrAnalysis.status_id`, type "Analysis")**

| ID | Name |
|---|---|
| 10 | Pending |
| 11 | Ongoing |
| 12 | Completed |
| 13 | Cancelled |
| 44* | Refunded (*in active use; not present in the seeder file — see Appendix D) |

**Releasing status (type "Releasing")**

| ID | Name |
|---|---|
| 26 | Pending |
| 27 | Completed |

**Disposal status (type "Disposal")**

| ID | Name |
|---|---|
| 28 | Pending |
| 29 | Completed |

**Test-report sign-off status (type "Testreport")**

| ID | Name |
|---|---|
| 38 | Pending |
| 39 | Analyzed |
| 40 | Certified |
| 41 | Approved (defined; skipped in code — flow jumps to 42) |
| 42 | Completed/Approved |

**Test-service catalog status (type "Testservice")**

| ID | Name |
|---|---|
| 31 | Pending |
| 32 | Approved |
| 33 | Suspended |
| 34 | Rejected |

**Equipment status**

| ID | Name |
|---|---|
| 35 | Operational |
| 36 | Disposed |
| 37 | Not in Use |

**Discount catalog (100%-off / "gratis" categories, auto-bypassing payment)**

| ID | Name |
|---|---|
| 5 | Fully Subsidized |
| 6 | Gratis |
| 7 | Health Units |
| 10 | Gratis – Calibration |
| 11 | Gratis – R&D |
| 12 | Gratis – QC |

\newpage

## Appendix D — Current Implementation Notes (Gap Register)

This appendix records specific points where the deployed code does not yet fully satisfy the requirement it relates to, discovered while researching this SRS. It is intended as a **prioritized remediation backlog**, not a criticism of the team — several items are clearly in-progress features (e.g., online payment integrations still carry sandbox/test values). Each item references the requirement it affects.

### D.1 Access control gaps (high priority — affects NFR-SEC-01, NFR-SEC-02, FR-INS-07, FR-ACC-07)

- The **Insights**, **Accomplishments**, and financial **Reports** route groups (`/insights/*`, `/accomplishments/*`, `/reports/*`) carry no authentication, 2FA, or role middleware at all — they are reachable by an anonymous visitor who knows or guesses the URL, including the `PUT /accomplishments/update` endpoint that edits management KPI targets. This should be wrapped in the same `['2fa','auth','verified']` (and an appropriate management-role) middleware used elsewhere.
- The route group intended to restrict `Laboratory Analyst, Calibration Officer, Technical Manager, Laboratory Head` is declared in `routes/web.php` but is empty — no routes are actually registered inside it, so those modules rely only on the general authenticated-session gate plus inline, per-query checks.
- Role-restricted route groups (Finance, Executive, Releasing) do not include the `2fa`/`verified` middleware that the general staff group uses — 2FA state persists via the session once satisfied, but a session that reaches one of these groups without first passing through the general group would not be challenged for 2FA at that point.

### D.2 Payment integration gaps (affects FR-PAY-06, NFR-SEC-04)

- Neither PayMongo webhook handler (`/webhook/paymongo`, and the customer-domain `/payments/webhook`) verifies the provider's signature header — payloads are currently trusted as-is.
- The customer-domain `/payments/webhook` endpoint is functionally a stub (acknowledges receipt but does not update any record) and is additionally registered behind the `auth:customer` guard, which a server-to-server webhook call cannot satisfy.
- The eGovPay integration uses a hardcoded sandbox token prefix, a hardcoded merchant-channel identifier, and hardcoded test customer details (name/mobile/e-mail) in the transaction-creation payload; its callback endpoint only logs the payload without updating payment status. This integration should be treated as pre-production.
- A duplicate, unused `EgovPayController copy.php` file exists alongside the real controller and should be removed.

### D.3 Customer-portal data isolation (affects FR-CUST-09)

- The customer-portal "request a quotation" feature (`CustomerQuotationController`) currently reads and writes a single hardcoded quotation record (`id = 1`) rather than the authenticated customer's own quotation — every logged-in customer is currently working against the same record. This needs to be fixed before the self-service quotation feature is enabled for real customers.
- `routes/customer.php` registers a `downloads` resource pointing at the same controller as `tsrs`, and a related "folder/file viewer" concept (`Viewer\*` controllers, an orphaned `Pages/Customer/Tsrs/View/Index.vue`) is present only as unreferenced scaffolding. This should be removed or completed, not left half-wired.

### D.4 Authentication edge cases (affects FR-AUTH-03, FR-AUTH-09)

- `PasswordResetLinkController` type-hints a `ForgotRequest` class that does not exist anywhere in the codebase, and separately calls `RateLimiter` without importing it — as written, the "forgot password" flow will error rather than complete. This is a functional break in FR-AUTH-09 and should be fixed with priority.
- The activation-code length is inconsistent: password-login (`LoginController`) issues a 6-digit code, while the activation wizard, social login, and mobile-OTP staff login all validate/issue a 9-digit code — a staff member activating via the password path cannot complete activation as currently coded.
- Customer OTP codes are stored in plaintext (a code comment states an intent to hash them that was not carried out) and compared with a non-constant-time string comparison; recommend hashing at rest and using `hash_equals()` (see NFR-SEC-03).
- Facebook OAuth is wired in the router but has no corresponding credentials in configuration, so attempts to use it will fail gracefully back to the login page; either configure it or remove the option from the UI.

### D.5 Report authenticity verification (affects FR-VER-03)

- `TsrReport.secret_key` and `TsrSampleReport.passkey` are generated, encrypted, and stored specifically to support a challenge-response verification step, but the live `/verification/{code}` and `/verification/sample/{code}` pages do not actually request or check them — authenticity currently rests on the difficulty of reversing the Hashids-encoded URL alone. Wiring the existing passkey into the verification page would meaningfully strengthen FR-VER-03.
- The `/pnpki` route points to a controller method that is entirely commented out; hitting it currently errors. Either finish or remove this route.

### D.6 Modules present in the UI/routing but not functionally complete

- **Executive → References** (HR reference data: positions, salary grades, leave types, deductions, organizational units) is fully scaffolded in routes, controller, service classes, and Vue pages, but the underlying Eloquent models and database tables do not exist; only the "Status" sub-option works. Treat as a planned-but-unbuilt module (§3.16 does not currently include it as a requirement for this reason).
- **Executive → FacilityController** is unregistered in routing and depends on a `Facility` model that does not exist; in the working system, facility management happens inside the Agency screens instead (FR-AGN-03–05). This controller/service/Vue set appears to be dead code from an earlier design and is a candidate for removal.
- **AWS Rekognition** facial-recognition indexing is configured (credentials, collection ID) and partially coded (`RekognitionController`, `RekognitionClass`), but is not called from any route, and depends on a `UserFace` model that does not exist. It is not part of any live authentication or attendance workflow today.
- **Inventory stock-out / withdrawal** has a defined ledger model (`InventoryWithdrawal`) that is never written to, and the inventory "Checkout" screen's submit action is not wired to any backend endpoint — FR-INV-05 should be treated as not yet delivered.
- **`User` model HR sub-records** (employment contracts, academic credentials, payroll deductions/credits, personal document folders) have corresponding UI modal shells but no backing models, migrations, or persistence logic. Do not represent these as working features to stakeholders.
- **Insights → Payments** and **Insights → Laboratories** dashboards (FR-INS-05, FR-INS-06) are registered routes with empty controller classes; visiting them currently errors.
- Quality/turnaround-time performance objectives (e.g., "99% of reports issued on time," "100% result accuracy") exist in the objective catalog used by Accomplishment reporting but are hardcoded to report zero — FR-ACC-08 is defined but not yet measurable, pending instrumentation of actual turnaround-time/accuracy data.
- `TsrSignatory` (intended for the sample-intake receive/review/collect sign-off chain) has a database table but an empty, unused model — the intake sign-off chain described conceptually in the data model is not currently exercised anywhere.
- The test-report final-approval signatory is currently hardcoded to a specific staff member's user ID rather than being resolved by role (contrast with the Technical Manager step, which is correctly resolved dynamically per laboratory). This should be generalized to avoid a single point of failure if that individual's account changes.
- Several `*Class copy*.php` backup files exist in the codebase (Signing/Testreport services) and should be removed to avoid confusion about which implementation is live.

### D.7 Single-tenant hardcoding despite multi-tenant design (affects NFR-MAINT-01)

- The GAD reporting module hardcodes the active agency ID and the current reporting year rather than deriving them from configuration or the logged-in user's context; onboarding a second agency or rolling into a new reporting year currently requires a code change in this module specifically.
- The SMS notification text sent on report release hardcodes the pickup location's name and address; a second-facility or multi-agency deployment would need this templated per facility.

### D.8 Data-consistency pattern to be aware of

- Monetary fields throughout the system (fees, totals, discounts, wallet balances, receipt amounts) are stored as decimals but consistently accessed through peso-symbol-formatted string accessors/mutators, with individual controllers stripping the currency symbol/commas back out before doing arithmetic. This repeated, copy-pasted pattern works today but is a latent source of parsing bugs if a new code path forgets the strip step; centralizing it into a single shared value object/helper is recommended as a maintainability improvement, not a functional defect.

---

*End of document.*
