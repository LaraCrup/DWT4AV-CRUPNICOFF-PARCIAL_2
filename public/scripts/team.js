const team = [
    {
        name: "Manuela Pérez",
        role: "Fundadora CEO",
        img: "manuela-perez",
        desc: "Apasionada por la repostería, Manuela lidera el equipo con creatividad y dedicación."
    },
    {
        name: "Juan Gómez",
        role: "Maestro pastelero",
        img: "juan-gomez",
        desc: "Experto en sabores, Juan crea recetas únicas para cada ocasión."
    },
    {
        name: "Sofía López",
        role: "Atención al cliente",
        img: "sofia-lopez",
        desc: "Sofía se asegura de que cada cliente tenga una experiencia inolvidable."
    },
    {
        name: "Carlos Ruiz",
        role: "Logística",
        img: "carlos-ruiz",
        desc: "Carlos organiza los envíos para que cada torta llegue perfecta y a tiempo."
    },
    {
        name: "Lucía Fernández",
        role: "Diseñadora",
        img: "lucia-fernandez",
        desc: "Lucía decora cada torta con creatividad y atención al detalle."
    },
    {
        name: "Martín Castro",
        role: "Marketing",
        img: "martin-castro",
        desc: "Martín comparte la pasión de Tortas Manuela con el mundo."
    }
];

const teamContainer = document.getElementById('teamMembers');
team.forEach(member => {
    const div = document.createElement('div');
    div.className = 'fontBody';
    div.innerHTML = `
                <img src="/storage/team/${member.img}.webp" alt="${member.name}">
                <p class="fontTitle">${member.name}</p>
                <p>${member.role}</p>
                <p>${member.desc}</p>
            `;
    teamContainer.appendChild(div);
});