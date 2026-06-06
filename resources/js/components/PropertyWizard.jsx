import { useState, useMemo } from "react";
import { useQuery, useMutation } from "@tanstack/react-query";

// ---------- helpers ----------
const token = () =>
  document.getElementById("property-wizard")?.dataset?.token ?? "";

const api = (path, opts = {}) =>
  fetch(path, {
    headers: {
      Authorization: `Bearer ${token()}`,
      "Content-Type": "application/json",
      Accept: "application/json",
    },
    ...opts,
  }).then((r) => r.json());

// ---------- Step indicators ----------
function StepBar({ step }) {
  const steps = ["Basics", "Details", "Pricing"];
  return (
    <div className="flex items-center justify-center mb-8 gap-0">
      {steps.map((label, i) => {
        const num = i + 1;
        const active = num === step;
        const done = num < step;
        return (
          <div key={label} className="flex items-center">
            <div className="flex flex-col items-center">
              <div
                className={`w-9 h-9 rounded-full flex items-center justify-center text-sm font-semibold border-2 transition-all
                  ${done ? "bg-primary border-primary text-white" : ""}
                  ${active ? "bg-primary border-primary text-white scale-110" : ""}
                  ${!done && !active ? "bg-white border-gray-300 text-gray-400" : ""}`}
              >
                {done ? "✓" : num}
              </div>
              <span
                className={`text-xs mt-1 font-medium ${active ? "text-primary" : "text-gray-400"}`}
              >
                {label}
              </span>
            </div>
            {i < steps.length - 1 && (
              <div
                className={`h-0.5 w-16 mx-1 mb-5 transition-all ${done ? "bg-primary" : "bg-gray-200"}`}
              />
            )}
          </div>
        );
      })}
    </div>
  );
}

// ---------- Step 1: Basics ----------
function StepBasics({ data, onChange, errors, categories = [] }) {
  return (
    <div className="space-y-5">
      {/* Title */}
      <div className="form-control">
        <label className="label">
          <span className="label-text font-medium">Title *</span>
        </label>
        <input
          type="text"
          className={`input input-bordered w-full rounded-xl ${errors.title ? "input-error" : ""}`}
          placeholder="e.g., Bright apartment near the city centre"
          value={data.title}
          onChange={(e) => onChange("title", e.target.value)}
        />
        {errors.title && (
          <p className="text-error text-xs mt-1">{errors.title}</p>
        )}
      </div>

      {/* Description */}
      <div className="form-control">
        <label className="label">
          <span className="label-text font-medium">Description *</span>
        </label>
        <textarea
          className="textarea textarea-bordered w-full rounded-xl"
          rows={3}
          placeholder="Describe the property..."
          value={data.description}
          onChange={(e) => onChange("description", e.target.value)}
        />
        {errors.description && (
          <p className="text-error text-xs mt-1">{errors.description}</p>
        )}
      </div>

      {/* Category — fetched via TanStack Query */}
      <div className="form-control">
        <label className="label">
          <span className="label-text font-medium">Category *</span>
        </label>
        <select
          className="select select-bordered w-full rounded-xl"
          value={data.category_id}
          onChange={(e) => onChange("category_id", e.target.value)}
        >
          <option value="">Select a category</option>
          {categories.map((c) => (
            <option key={c.id} value={c.id}>
              {c.name}
            </option>
          ))}
        </select>
        {errors.category_id && (
          <p className="text-error text-xs mt-1">{errors.category_id}</p>
        )}
      </div>

      {/* Property type */}
      <div className="form-control">
        <label className="label">
          <span className="label-text font-medium">Property Type *</span>
        </label>
        <select
          className="select select-bordered w-full rounded-xl"
          value={data.property_type}
          onChange={(e) => onChange("property_type", e.target.value)}
        >
          <option value="">Select type</option>
          <option value="apartment">Apartment</option>
          <option value="house">House</option>
          <option value="villa">Villa</option>
          <option value="studio">Studio</option>
        </select>
      </div>

      {/* Listing type — radio buttons (changes Step 3 calculator formula) */}
      <div className="form-control">
        <label className="label">
          <span className="label-text font-medium">Listing Type *</span>
        </label>
        <div className="flex gap-6 mt-1">
          {["rent", "sale"].map((val) => (
            <label key={val} className="flex items-center gap-2 cursor-pointer">
              <input
                type="radio"
                className="radio radio-primary"
                name="listing_type"
                value={val}
                checked={data.listing_type === val}
                onChange={() => onChange("listing_type", val)}
              />
              <span className="capitalize font-medium">For {val}</span>
            </label>
          ))}
        </div>
        <p className="text-xs text-gray-400 mt-1">
          This determines how pricing is calculated in Step 3.
        </p>
      </div>
    </div>
  );
}

// ---------- Step 2: Details ----------
function StepDetails({ data, onChange, errors }) {
  const amenities = [
    { key: "has_pool", label: "🏊 Pool" },
    { key: "has_gym", label: "🏋️ Gym" },
    { key: "has_parking", label: "🚗 Parking" },
  ];

  return (
    <div className="space-y-5">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
        {/* Address */}
        <div className="form-control md:col-span-2">
          <label className="label">
            <span className="label-text font-medium">Address *</span>
          </label>
          <input
            type="text"
            className="input input-bordered w-full rounded-xl"
            placeholder="Street address"
            value={data.address}
            onChange={(e) => onChange("address", e.target.value)}
          />
          {errors.address && (
            <p className="text-error text-xs mt-1">{errors.address}</p>
          )}
        </div>

        {/* City */}
        <div className="form-control">
          <label className="label">
            <span className="label-text font-medium">City *</span>
          </label>
          <input
            type="text"
            className="input input-bordered w-full rounded-xl"
            placeholder="Budapest"
            value={data.city}
            onChange={(e) => onChange("city", e.target.value)}
          />
          {errors.city && (
            <p className="text-error text-xs mt-1">{errors.city}</p>
          )}
        </div>

        {/* Available from */}
        <div className="form-control">
          <label className="label">
            <span className="label-text font-medium">Available From *</span>
          </label>
          <input
            type="date"
            className="input input-bordered w-full rounded-xl"
            value={data.available_from}
            onChange={(e) => onChange("available_from", e.target.value)}
          />
        </div>

        {/* Sq meters */}
        <div className="form-control">
          <label className="label">
            <span className="label-text font-medium">Area (m²) *</span>
          </label>
          <input
            type="number"
            min="1"
            className="input input-bordered w-full rounded-xl"
            placeholder="65"
            value={data.sq_meters}
            onChange={(e) => onChange("sq_meters", e.target.value)}
          />
        </div>

        {/* Bedrooms */}
        <div className="form-control">
          <label className="label">
            <span className="label-text font-medium">Bedrooms</span>
          </label>
          <input
            type="number"
            min="0"
            className="input input-bordered w-full rounded-xl"
            placeholder="2"
            value={data.bedrooms}
            onChange={(e) => onChange("bedrooms", e.target.value)}
          />
        </div>

        {/* Bathrooms */}
        <div className="form-control">
          <label className="label">
            <span className="label-text font-medium">Bathrooms</span>
          </label>
          <input
            type="number"
            min="0"
            className="input input-bordered w-full rounded-xl"
            placeholder="1"
            value={data.bathrooms}
            onChange={(e) => onChange("bathrooms", e.target.value)}
          />
        </div>
      </div>

      {/* Amenities — checkboxes (required input type) */}
      <div className="form-control">
        <label className="label">
          <span className="label-text font-medium">Amenities</span>
        </label>
        <div className="flex gap-6 flex-wrap mt-1">
          {amenities.map(({ key, label }) => (
            <label key={key} className="flex items-center gap-2 cursor-pointer">
              <input
                type="checkbox"
                className="checkbox checkbox-primary"
                checked={!!data[key]}
                onChange={(e) => onChange(key, e.target.checked)}
              />
              <span>{label}</span>
            </label>
          ))}
        </div>
      </div>
    </div>
  );
}

// ---------- Step 3: Pricing + Live Calculator ----------
function StepPricing({ data, onChange, calculation }) {
  return (
    <div className="space-y-5">
      <div className="form-control">
        <label className="label">
          <span className="label-text font-medium">
            Price (€) *{" "}
            <span className="text-gray-400 font-normal">
              {data.listing_type === "rent" ? "— monthly rent" : "— sale price"}
            </span>
          </span>
        </label>
        <input
          type="number"
          min="0"
          className="input input-bordered w-full rounded-xl text-xl"
          placeholder={data.listing_type === "rent" ? "850" : "45000000"}
          value={data.price}
          onChange={(e) => onChange("price", e.target.value)}
        />
      </div>

      {/* Live calculator — updates instantly via useMemo */}
      {calculation && (
        <div className="bg-base-200 rounded-2xl p-5 border border-base-300 transition-all">
          <p className="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-2">
            Live calculation
          </p>
          <div className="flex items-baseline gap-3">
            <span className="text-3xl font-bold text-primary">
              {calculation.value}
            </span>
            <span className="text-gray-500">{calculation.label}</span>
          </div>
          {data.listing_type === "sale" && (
            <p className="text-xs text-gray-400 mt-2">
              Based on 5% annual interest, 25-year mortgage term.
            </p>
          )}
          {data.listing_type === "rent" && (
            <p className="text-xs text-gray-400 mt-2">
              Monthly rent ÷ area in m².
            </p>
          )}
        </div>
      )}

      {/* Image upload */}
      <div className="form-control">
        <label className="label">
          <span className="label-text font-medium">Property Image</span>
        </label>
        <input
          type="file"
          accept="image/*"
          className="file-input file-input-bordered w-full rounded-xl"
          onChange={(e) => onChange("image", e.target.files[0] ?? null)}
        />
      </div>

      {/* Summary */}
      <div className="bg-primary/5 border border-primary/20 rounded-2xl p-4 text-sm space-y-1">
        <p className="font-semibold text-primary mb-2">Summary</p>
        <p>
          <span className="text-gray-500">Title:</span> {data.title || "—"}
        </p>
        <p>
          <span className="text-gray-500">Type:</span> {data.property_type} —{" "}
          {data.listing_type}
        </p>
        <p>
          <span className="text-gray-500">Location:</span>{" "}
          {[data.address, data.city].filter(Boolean).join(", ") || "—"}
        </p>
        <p>
          <span className="text-gray-500">Area:</span>{" "}
          {data.sq_meters ? `${data.sq_meters} m²` : "—"}
        </p>
      </div>
    </div>
  );
}

// ---------- Main Wizard ----------
export default function PropertyWizard() {
  const [step, setStep] = useState(1);
  const [errors, setErrors] = useState({});
  const [formData, setFormData] = useState({
    title: "",
    description: "",
    category_id: "",
    property_type: "",
    listing_type: "rent",
    address: "",
    city: "",
    available_from: "",
    sq_meters: "",
    bedrooms: "",
    bathrooms: "",
    has_pool: false,
    has_gym: false,
    has_parking: false,
    price: "",
    image: null,
  });

  // Fetch categories with TanStack Query on mount
  const { data: categories = [], isLoading: catsLoading } = useQuery({
    queryKey: ["categories"],
    queryFn: () => api("/api/categories"),
  });

  // Live financial calculator — derived state via useMemo
  const calculation = useMemo(() => {
    const price = Number(formData.price);
    const sqm = Number(formData.sq_meters);
    if (!price || price <= 0) return null;
    if (formData.listing_type === "rent") {
      if (!sqm || sqm <= 0) return null;
      return {
        label: "Price per m²",
        value: `€${(price / sqm).toFixed(2)}/m²`,
      };
    } else {
      // Monthly mortgage: P × [r(1+r)^n] / [(1+r)^n − 1]
      const r = 0.05 / 12;
      const n = 25 * 12;
      const monthly = price * (r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);
      return {
        label: "Est. monthly mortgage",
        value: `€${Math.round(monthly).toLocaleString()}/mo`,
      };
    }
  }, [formData.price, formData.sq_meters, formData.listing_type]);

  // Mutation for final submit
  const mutation = useMutation({
    mutationFn: async (data) => {
      // Use FormData to support file upload
      const fd = new FormData();
      Object.entries(data).forEach(([k, v]) => {
        if (v !== null && v !== undefined && v !== "") {
          if (typeof v === "boolean") fd.append(k, v ? "1" : "0");
          else fd.append(k, v);
        }
      });
      return fetch("/api/properties", {
        method: "POST",
        headers: { Authorization: `Bearer ${token()}`, Accept: "application/json" },
        body: fd,
      }).then((r) => r.json());
    },
    onSuccess: (res) => {
      if (res.id) {
        window.location.href = "/user/properties";
      }
    },
  });

  const onChange = (key, value) => {
    setFormData((prev) => ({ ...prev, [key]: value }));
    setErrors((prev) => ({ ...prev, [key]: undefined }));
  };

  const validateStep = () => {
    const errs = {};
    if (step === 1) {
      if (!formData.title.trim()) errs.title = "Title is required";
      if (!formData.description.trim()) errs.description = "Description is required";
      if (!formData.category_id) errs.category_id = "Pick a category";
    }
    if (step === 2) {
      if (!formData.address.trim()) errs.address = "Address is required";
      if (!formData.city.trim()) errs.city = "City is required";
    }
    setErrors(errs);
    return Object.keys(errs).length === 0;
  };

  const next = () => {
    if (validateStep()) setStep((s) => s + 1);
  };
  const back = () => setStep((s) => s - 1);

  const handleSubmit = (e) => {
    e.preventDefault();
    if (validateStep()) mutation.mutate(formData);
  };

  return (
    <div className="max-w-2xl mx-auto">
      <StepBar step={step} />

      <div className="bg-white rounded-2xl shadow-md p-6 md:p-8">
        {mutation.isError && (
          <div className="alert alert-error mb-4 rounded-xl">
            Submission failed — please try again.
          </div>
        )}

        {step === 1 && (
          <StepBasics
            data={formData}
            onChange={onChange}
            errors={errors}
            categories={catsLoading ? [] : categories}
          />
        )}
        {step === 2 && (
          <StepDetails data={formData} onChange={onChange} errors={errors} />
        )}
        {step === 3 && (
          <StepPricing
            data={formData}
            onChange={onChange}
            calculation={calculation}
          />
        )}

        {/* Navigation buttons */}
        <div className="flex justify-between mt-8">
          {step > 1 ? (
            <button
              type="button"
              className="btn btn-outline rounded-xl"
              onClick={back}
            >
              ← Back
            </button>
          ) : (
            <div />
          )}

          {step < 3 ? (
            <button
              type="button"
              className="btn btn-primary rounded-xl px-8"
              onClick={next}
            >
              Next →
            </button>
          ) : (
            <button
              type="submit"
              className="btn btn-primary rounded-xl px-8"
              disabled={mutation.isPending}
              onClick={handleSubmit}
            >
              {mutation.isPending ? (
                <span className="loading loading-spinner" />
              ) : (
                "Publish listing ✓"
              )}
            </button>
          )}
        </div>
      </div>

      {/* Step indicator text */}
      <p className="text-center text-xs text-gray-400 mt-3">
        Step {step} of 3
      </p>
    </div>
  );
}
