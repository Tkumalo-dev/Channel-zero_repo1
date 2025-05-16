document.addEventListener('DOMContentLoaded', () => {
  const fundsForm = document.getElementById('funds-form');
  const fundResult = document.getElementById('fund-result');
  const loader = document.getElementById('loader');
  const container = document.querySelector('.container');
  const resetBtn = document.getElementById('reset-btn');

  fundsForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const firstName = document.getElementById('first-name').value.trim();
    const lastName = document.getElementById('last-name').value.trim();
    const dob = document.getElementById('dob').value;
    const idNum = document.getElementById('idnum').value.trim();

    if (!firstName || !lastName || !dob || !idNum) {
      fundResult.innerHTML = `<div class="fund-card"><p style="color: red;">Please fill in all fields.</p></div>`;
      return;
    }

    // Switch layout
    container.classList.remove('initial');
    container.classList.add('split');
    resetBtn.style.display = 'block';
    loader.style.display = 'block';
    fundResult.innerHTML = '';

    setTimeout(() => {
      loader.style.display = 'none';

      const hasFunds = Math.random() > 0.5;

      if (hasFunds) {
        const funds = [
          { institution: "National Treasury", amount: "R2,350", ref: "NT123456" },
          { institution: "Old Mutual", amount: "R1,200", ref: "OM789654" }
        ];

        fundResult.innerHTML = funds.map(fund => `
          <div class="fund-card">
            <p><strong>Institution:</strong> ${fund.institution}</p>
            <p><strong>Amount:</strong> ${fund.amount}</p>
            <p><strong>Reference:</strong> ${fund.ref}</p>
            <button class="claim-btn" onclick="alert('You claimed ${fund.amount} from ${fund.institution}!')">Claim</button>
          </div>
        `).join('');
      } else {
        fundResult.innerHTML = `
          <div class="fund-card">
            <p style="color: #e74a3b;">No unclaimed funds found for ${firstName} ${lastName}.</p>
          </div>`;
      }
    }, 1500);
  });

  resetBtn.addEventListener('click', () => {
    container.classList.remove('split');
    container.classList.add('initial');
    fundsForm.reset();
    fundResult.innerHTML = '';
    resetBtn.style.display = 'none';
  });
});
